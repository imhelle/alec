<?php

namespace app\controllers;

use app\models\UploadedData;
use moonland\phpexcel\Excel;
use Yii;
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
                return ['error' => $e->getMessage() . PHP_EOL . $e->getTraceAsString()];
            }
        }
//        var_dump($model->errors);
    }

}
