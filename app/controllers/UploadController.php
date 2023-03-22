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
//                    foreach ($model->files as $file) {
//                        $data = Excel::import($file->tempName, [
//                            'setFirstRecordAsKeys' => false
//                        ]);
//                    }
                }
            } catch (\Exception $e) {
                return json_encode(['error' => $e->getMessage()]);
            }
        }
//        var_dump($model->errors);
    }

}
