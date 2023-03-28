<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

class Study extends \app\models\ar\Study
{
    public function loadFromXLSX($xlsxArray)
    {
        if ($xlsxArray[0] == 'email') {
            $this->email = $xlsxArray[0]['B'];
        }
    }
        public function attributeLabels()
    {
        return [
            'doi' => Yii::t('app', 'DOI'),
            'pmid' => Yii::t('app', 'PMID'),
        ];
    }
    
    public static function getRecordByData($data)
    {
        $model = self::find()->where(['or', 
            ['pubmed_id' => UploadedData::getRowValue('PMID', $data)],
            ['doi' => UploadedData::getRowValue('DOI', $data)],
            ])->one();
        if (!$model) {
            $model = new self();
            $model->journal = UploadedData::getRowValue('Journal', $data);
            $model->doi = UploadedData::getRowValue('DOI', $data);
            $model->pubmed_id = (string)UploadedData::getRowValue('PMID', $data);
            $model->full_text_URL = null;
            $model->email = UploadedData::getRowValue('Email', $data);
            $model->authors = UploadedData::getRowValue('Authors', $data);
            $model->year = UploadedData::getRowValue('Year', $data);
            $model->remarks = UploadedData::getRowValue('Remarks', $data);
            $model->timestamp = date('Y-m-d H:i:s');
            if (!$model->save()) {
                return json_encode($model->errors);
            }
        }
        return $model;
    }

}
