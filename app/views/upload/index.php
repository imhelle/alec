<?php
/** @var $model UploadedData */

use app\models\UploadedData;
use kartik\file\FileInput;
use yii\helpers\Url;


echo FileInput::widget([
    'model' => $model,
    'attribute' => 'files[]',
    'options'=>[
        'multiple'=>true
    ],
    'pluginOptions' => [
        'uploadUrl' => Url::to(['/upload/upload']),
        'maxFileCount' => 100,
        'minFileCount' => 3,
        'uploadAsync' => false,
        'allowedFileExtensions' => ['xlsx']
    ]
]);



