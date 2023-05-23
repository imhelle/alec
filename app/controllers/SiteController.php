<?php

namespace app\controllers;

use app\infrastructure\ChartHelper;
use app\models\Cohort;
use app\models\SavedLink;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class SiteController extends Controller
{

    public function actionIndex()
    {
        $charts = [];
        if (Yii::$app->request->queryParams['chart']) {
            $savedLink = SavedLink::find()->where(['link' => Yii::$app->request->queryParams['chart']])->one();
            if($savedLink && $savedLink->chart) {
                $charts = json_decode($savedLink->chart, true);
            }
        }
        $allControlsCoordinates = ChartHelper::getCoordinates($this->getDataFromCohortQuery('active_substance_id is null'));
        
        $cohortSearchModel = new Cohort();
        $cohortDataProvider = $cohortSearchModel->search(Yii::$app->request->queryParams);
        $cohortDataQuery = $cohortDataProvider->query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql;
        $cohortIndex = strpos(strtolower($cohortDataQuery), 'where') + strlen('where');
        $cohortQuery = substr($cohortDataQuery, $cohortIndex);
        
        $data = $this->getDataFromCohortQuery($cohortQuery);
        $coords = ChartHelper::getCoordinates($data);
        $median = $this->getMedian($data);
        $total = Cohort::getActiveCount();

        if (Yii::$app->request->isAjax && Yii::$app->request->getQueryParam('getCoords') == 1) {
            $label = Cohort::buildLabel($cohortQuery);
            return (json_encode(['label' => $label, 'coords' => $coords, 'median' => $median]));
        }

        if (Yii::$app->request->getQueryParam('getFile') == 1) {
            $label = preg_replace("/[^A-Za-z0-9]+/", '_', Cohort::buildLabel($cohortQuery));
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

        return $this->render('index', [
            'allControlsCoordinates' => $allControlsCoordinates,
            'cohortSearchModel' => $cohortSearchModel,
            'cohortDataProvider' => $cohortDataProvider,
            'charts' => $charts,
            'median' => $median,
            'total' => $total,
        ]);
    }
    
    public function actionChart($link)
    {
        $savedLink = SavedLink::find()->where(['link' => $link])->one();
        if (!$savedLink) {
            return $this->redirect('/');
        }
        $operand = $savedLink->url ? '&' : '?';
        return $this->redirect('/' . rtrim($savedLink->url, '/') . $operand . 'chart=' . $savedLink->link);
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

    public function actionError()
    {
        return $this->render('error', [

        ]);
    }

    private function getDataFromCohortQuery($query): array
    {
//        var_dump($query); die;
        return \app\models\Cohort::find()
            ->leftJoin('{{%lifespan}}', '{{%lifespan}}.cohort_id={{%cohort}}.id')
            ->leftJoin('{{%strain}}', '{{%cohort}}.strain_id={{%strain}}.id')
            ->select('{{%lifespan}}.age')
            ->where($query)
            ->orderBy('age desc')
            ->column();
    }

    private function getMedian($data)
    {
        if (!$data) {
            return null;
        }
        arsort($data);
        $keys = array_keys($data);
        return $data[round(count($keys) / 2)];
    }

}
