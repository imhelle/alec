<?php

namespace app\controllers;

use app\models\UploadedData;
use moonland\phpexcel\Excel;
use Yii;
use yii\log\Logger;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Upload controller
 */
class UploadController extends Controller
{

    public function actionIndex(): string
    {
        $model = new UploadedData();

        $this->view->title = 'ALEC - Animal Life Expectancy Comparisons';
        return $this->render('index', [
            'model' => $model,
        ]);
        
    }
    
    public function actionUpload()
    {
        $model = new UploadedData();
        if (Yii::$app->request->isPost) {
            $this->response->format = Response::FORMAT_JSON;
            try {
                $model->setExperimentFiles(UploadedFile::getInstances($model, 'files'));
                if ($model->validate()) {
                    $model->importToDb();
                }
            } catch (\Exception $e) {
                
                Yii::getLogger()->log($e->getMessage() . PHP_EOL . $e->getTraceAsString(), Logger::LEVEL_WARNING);
                return ['error' => $e->getMessage()];
            }
        }
        return [];
    }

}
