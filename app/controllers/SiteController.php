<?php

namespace app\controllers;

use app\models\common\LoginForm;
use app\models\common\PasswordResetRequestForm;
use app\models\common\ResetPasswordForm;
use app\models\common\SignupForm;
use app\models\ExperimentSearch;
use Yii;
use yii\base\InvalidArgumentException;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Request;

/**
 * Site controller
 */
class SiteController extends Controller
{

    public function actionIndex()
    {
        $allControlsCoordinates = $this->getCoordinates($this->getDataFromQuery('`group` in ("Nodrug", "Controls")'));
        $allDrugCoordinates = $this->getCoordinates($this->getDataFromQuery('`group`="Drug"'));

        $searchModel = new ExperimentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataQuery = $dataProvider->query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql;
        $index = strpos(strtolower($dataQuery), 'where') + strlen('where');
        $query = substr($dataQuery, $index);
        $query = $query !== 'T * FROM `experiment`' ? $query : '1';

        $data = $this->getDataFromQuery($query);
        $coords = $this->getCoordinates($data);
        $median = $this->getMedian($data);
        $total = $searchModel::find()->count();

        if (Yii::$app->request->isAjax && isset(Yii::$app->request->queryParams['getCoords']) && Yii::$app->request->queryParams['getCoords'] == 1) {
            $label = trim(str_replace(['`', '%', '(', ')', '\''], '', $query));
            $label = str_replace([' AND '], ', ', $label);
            $label = str_replace([' LIKE '], '=', $label);
            $label = str_replace(["sex=0"], 'Female', $label);
            $label = str_replace(["sex=1"], 'Male', $label);
            $label = str_replace(["drug_name=", 'group=', 'status=', 'site=', 'year=', 'age=', 'strain=', 'strain IN '], '', $label);
            $label = str_replace(["group IN Controls, Nodrug"], "Control+Nodrug", $label);
            $label = ($label == '1') ? 'All' : $label;
            return (json_encode(['label' => $label, 'coords' => $coords, 'median' => $median]));
        }

        return $this->render('index', [
            'allControlsCoordinates' => $allControlsCoordinates,
            'allDrugCoordinates' => $allDrugCoordinates,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'median' => $median,
            'total' => $total,
        ]);
    }
    
    public function actionUpload()
    {
        return $this->render('upload', [
        ]);
    }

    public function actionError()
    {
        return $this->render('error', [

        ]);
    }

    private function getDataFromQuery($query)
    {
        return \app\models\Experiment::find()
            ->select('age')
            ->where($query)
            ->orderBy('age desc')
            ->column();
    }

    private function getMedian($data)
    {
        if(!$data) {
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

}
