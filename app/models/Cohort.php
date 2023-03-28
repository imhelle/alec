<?php

namespace app\models;

use moonland\phpexcel\Excel;
use yii\web\UploadedFile;

class Cohort extends ar\Cohort
{
    public static function saveFromData($data, $studyId)
    {
        $model = new self();
        $model->study_id = $studyId;
        $model->temperature = trim(UploadedData::getRowValue('Temperature', $data));
        $model->dwelling_id = null; // todo
        $model->animals_per_dwelling = trim(UploadedData::getRowValue('Count of animals kept jointly', $data));
        $model->control = intval(filter_var(UploadedData::getRowValue('Control group?', $data), FILTER_VALIDATE_BOOLEAN));
        $model->cohort_size = intval(UploadedData::getRowValue('Cohort size', $data));
        $model->taxonomy_id = null; // todo
        $model->strain_id = null; // todo
        $model->sex = trim(UploadedData::getRowValue('Sex', $data));
        $model->age_of_start = intval(UploadedData::getRowValue('Start of treatment', $data));
        $model->smoothed_lifespan_last_decile_age = null;
        $model->smoothed_lifespan_median_age = null;
        $model->light_conditions = trim(UploadedData::getRowValue('Light conditions', $data));
        $model->diet_description = trim(UploadedData::getRowValue('Diet description', $data));
        $model->type_of_experiment = trim(UploadedData::getRowValue('Type of experiment', $data));
        $model->active_substance_id = null; // todo
        $model->dosage = trim(UploadedData::getRowValue('Dosage', $data)); // todo
        $model->vehicle = trim(UploadedData::getRowValue('Vehicle', $data)); 
        $model->diet_intervention_description = trim(UploadedData::getRowValue('Diet intervention short description', $data)); 
        $model->temperature_unit = null; // todo 
        $model->age_unit = null; // todo 
        $model->remarks = trim(UploadedData::getRowValue('Remarks', $data));
        $model->health_parameters = null;
        $model->timestamp = date('Y-m-d H:i:s');
        if (!$model->save()) {
            var_dump($model->errors);
        }
        
        return $model;
    }
}

