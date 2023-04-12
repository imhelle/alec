<?php

namespace app\controllers;

use app\models\Cohort;
use app\models\common\LoginForm;
use app\models\common\PasswordResetRequestForm;
use app\models\common\ResetPasswordForm;
use app\models\common\SignupForm;
use app\models\ExperimentSearch;
use app\models\Lifespan;
use Yii;
use yii\base\InvalidArgumentException;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Request;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class SiteController extends Controller
{

    public function actionIndex()
    {
        $allControlsCoordinates = $this->getCoordinates($this->getDataFromQuery('`group` in ("Nodrug", "Controls")'));
        $allDrugCoordinates = $this->getCoordinates($this->getDataFromQuery('`group`="Drug"'));
        
        $cohortSearchModel = new Cohort();
        $cohortDataProvider = $cohortSearchModel->search(Yii::$app->request->queryParams);
        $cohortDataQuery = $cohortDataProvider->query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql;
        $cohortIndex = strpos(strtolower($cohortDataQuery), 'where') + strlen('where');
        $cohortQuery = substr($cohortDataQuery, $cohortIndex);
        $cohortQuery = stripos($cohortQuery, 'where') !== false ? $cohortQuery : '1'; //!== 'T * FROM `' . getenv('DB_PREFIX') . 'cohort`' ? $cohortQuery : '1';
        
        $data = $this->getDataFromCohortQuery($cohortQuery);
        $coords = $this->getCoordinates($data);
        $median = $this->getMedian($data);
        $total = Lifespan::getActiveCount();

        if (Yii::$app->request->isAjax && isset(Yii::$app->request->queryParams['getCoords']) && Yii::$app->request->queryParams['getCoords'] == 1) {
            $label = $this->buildLabel($cohortQuery);
            return (json_encode(['label' => $label, 'coords' => $coords, 'median' => $median]));
        }

        if (isset(Yii::$app->request->queryParams['getFile']) && Yii::$app->request->queryParams['getFile'] == 1) {
//            $label = str_replace([',', ' '], '_', $this->buildLabel($query));
            $label = preg_replace("/[^A-Za-z0-9]+/", '_', $this->buildLabel($cohortQuery));
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
            'allDrugCoordinates' => $allDrugCoordinates,
            'cohortSearchModel' => $cohortSearchModel,
            'cohortDataProvider' => $cohortDataProvider,
            'median' => $median,
            'total' => $total,
        ]);
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
        $coordinates = $this->getCoordinates($survivalData);
        $median = $this->getMedian($survivalData);
        return (json_encode(['label' => $file->name, 'coords' => $coordinates, 'median' => $median]));
    }

    public function actionError()
    {
        return $this->render('error', [

        ]);
    }

    private function getDataFromQuery($query)
    {
        return \app\models\ExperimentOld::find()
            ->select('age')
            ->where($query)
            ->orderBy('age desc')
            ->column();
    }

    private function getDataFromCohortQuery($query): array
    {
//        var_dump($query); die;
        return \app\models\Cohort::find()
            ->innerJoin('{{%lifespan}}', '{{%lifespan}}.cohort_id={{%cohort}}.id')
            ->innerJoin('{{%strain}}', '{{%cohort}}.strain_id={{%strain}}.id')
            ->innerJoin('{{%active_substance}}', '{{%cohort}}.active_substance_id={{%active_substance}}.id')
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

    private function getCoordinates($data)
    {
        $coordinates = [];
        $counter = 1;
        foreach ($data as $drug) {
            $y = ($counter / count($data)) * 100;
            $coordinates[] = ['x' => (int)$drug, 'y' => $y];
            $counter++;
        }
        $coordinates[] = ['x' => 0, 'y' => 100];
        return $coordinates;
    }

    private function buildLabel($query)
    {
        $label = trim(str_replace(['`', '%', '(', ')', '\''], '', $query));
        $label = str_replace([' AND '], ', ', $label);
        $label = str_replace([' LIKE '], '=', $label);
        $label = str_replace(["sex=0"], 'Female', $label);
        $label = str_replace(["sex=1"], 'Male', $label);
        $label = str_replace(["drug_name=", 'group=', 'status=', 'site=', 'year=', 'age=', 'strain=', 'strain IN '], '', $label);
        $label = str_replace(["group IN Controls, Nodrug"], "Control+Nodrug", $label);
        return ($label == '1') ? 'All' : $label;
    }

}
