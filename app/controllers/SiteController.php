<?php

namespace app\controllers;

use app\infrastructure\ChartHelper;
use app\infrastructure\MetricsApi;
use app\infrastructure\MetricsApiInterface;
use app\models\Cohort;
use app\models\SavedLink;
use app\modules\contribute\models\LoginForm;
use Yii;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class SiteController extends Controller
{

    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    public function actionIndex()
    {
        $charts = [];
        if (Yii::$app->request->getQueryParam('chart')) {
            $savedLink = SavedLink::find()->where(['link' => Yii::$app->request->queryParams['chart']])->one();
            if($savedLink && $savedLink->chart) {
                $charts = json_decode($savedLink->chart, true);
            }
        }
        $allControlsCoordinates = ChartHelper::getCoordinates(Cohort::getDataFromQuery('active_substance_id is null'));
        
        $cohortSearchModel = new Cohort();
        $cohortDataProvider = $cohortSearchModel->search(Yii::$app->request->queryParams);
        $cohortDataQuery = $cohortDataProvider->query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql;
        $cohortIndex = strpos(strtolower($cohortDataQuery), 'where') + strlen('where');
        $cohortQuery = substr($cohortDataQuery, $cohortIndex);
        
        $data = Cohort::getDataFromQuery($cohortQuery);
        $coords = ChartHelper::getCoordinates($data);
        $median = $this->getMedian($data);
        $total = Cohort::getActiveCount();

//        var_dump(Yii::$app->request->isAjax);
//        var_dump(Yii::$app->request->getQueryParam('getCoords') == 1); 
//        die();
        if (Yii::$app->request->isAjax && Yii::$app->request->getQueryParam('getCoords') == 1) {
            $label = Cohort::buildLabelByQuery($cohortQuery);
            return (json_encode(['label' => $label, 'coords' => $coords, 'median' => $median]));
        }

        if (Yii::$app->request->getQueryParam('getFile') == 1) {
            $this->sendFile($cohortQuery, $data);
        }

        return $this->render('index', [
            'allControlsCoordinates' => $allControlsCoordinates,
            'cohortSearchModel' => $cohortSearchModel,
            'cohortDataProvider' => $cohortDataProvider,
            'charts' => $charts,
            'median' => $median,
            'total' => $total,
        ]);
    }
    
    private function sendFile($cohortQuery, $data)
    {
        $label = preg_replace("/[^A-Za-z0-9]+/", '_', Cohort::buildLabelByQuery($cohortQuery));
        $file = fopen('php://memory', 'w');
        foreach ($data as $line) {
            fputcsv($file, [$line]);
        }
        fseek($file, 0);
        header("Cache-Control: must-revalidate");
        header("Pragma: must-revalidate");
        header("Content-type: text/csv");
        header("Content-disposition: attachment; filename=$label.csv");
        fpassthru($file);
        exit();
    }
    
    public function actionChart($link)
    {
        $savedLink = SavedLink::find()->where(['link' => $link])->one();
        if (!$savedLink) {
            return $this->redirect('/');
        }
        $operand = $savedLink->url ? '&' : '?';
        $baseUrl = getenv('BASE_URL') ? '/' . getenv('BASE_URL') : '';
        return $this->redirect($baseUrl . '/'.rtrim($savedLink->url, '/') . $operand . 'chart=' . $savedLink->link);
    }
    
    
    
    public function actionSaveLink()
    {
        return SavedLink::saveLink(Yii::$app->request->post());
    }

    public function actionUpload()
    {
        $file = UploadedFile::getInstanceByName('upload');
        $fileContents = file($file->tempName);
        if ($file->type != 'text/csv') {
            return json_encode(['error' => 'Wrong file type']);
        }
        $survivalData = [];
        foreach ($fileContents as $line) {
            $line = trim($line);
            if (!is_numeric($line)) {
                return json_encode(['error' => 'Wrong data format']);
            }
            $survivalData[] = $line;
        }
        $coordinates = ChartHelper::getCoordinates($survivalData);
        $median = $this->getMedian($survivalData);
        return (json_encode(['label' => $file->name, 'coords' => $coordinates, 'median' => $median]));
    }
    
    public function actionIntraStudyMetricsByGraph()
    {
        $this->enableCsrfValidation = false;
        try {
             $data = Yii::$app->request->rawBody;
            /** @var MetricsApiInterface $metricsApi */
            $metricsApi = Yii::$container->get(MetricsApiInterface::class);
            
        } catch (Exception $e) {
            var_dump($e);
        }

        return $metricsApi->getIntraStudyMetricsByGraph($data);
    }

    public function actionIntraStudyMetricsByCohort($cohortId)
    {
        $this->enableCsrfValidation = false;
        try {
            $lifespans = Cohort::getLifespansArray($cohortId);
            
            $data = [
                'lifespans' => $lifespans,
                'species' => 'mice',
                'strain' => '123'                
                ];

            /** @var MetricsApiInterface $metricsApi */
            $metricsApi = Yii::$container->get(MetricsApiInterface::class);

        } catch (Exception $e) {
            var_dump($e);
        }
        
        return $metricsApi->getIntraStudyMetricsByLifespans(json_encode($data));
    }
    
    public function actionPlotByCohort($cohortId)
    {
        $label = Cohort::buildLabelById($cohortId);
        $data = Cohort::getLifespansArray($cohortId);
        $coords = ChartHelper::getCoordinates($data);
        $median = $this->getMedian($data);
        return (json_encode(['label' => $label, 'coords' => $coords, 'median' => $median, 'cohortId' => $cohortId]));
    }

    public function actionError()
    {
        return $this->render('error', [

        ]);
    }

    private function getMedian($data)
    {
        if (!$data) {
            return null;
        }
        arsort($data);
        $keys = array_keys($data);
        return $data[$keys[round(count($keys) / 2)]];
    }

}
