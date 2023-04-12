<?php

namespace app\models;

use moonland\phpexcel\Excel;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

class Cohort extends ar\Cohort
{
    public $searchStrain;
    
    public static function saveFromData($data, $studyId, $studyData)
    {
        $dwellingId = DwellingType::findOrCreateByName(UploadedData::getRowValue('Type of dwelling', $data))->id;
        $taxonomyId = Taxonomy::findOrCreateByName(UploadedData::getRowValue('Taxonomy name', $data))->id;
        $strainId = Strain::findOrCreateByNameAndTax(UploadedData::getRowValue('Strain', $data), $taxonomyId)->id;
        $activeSubstanceId = ActiveSubstance::findOrCreateByName(UploadedData::getRowValue('Active substance name', $data))->id;
        
        $model = new self();
        $model->study_id = $studyId;
        $model->temperature = trim(UploadedData::getRowValue('Temperature', $data));
        $model->dwelling_id = $dwellingId; 
        $model->animals_per_dwelling = trim(UploadedData::getRowValue('Count of animals kept jointly', $data));
        $model->control = intval(filter_var(UploadedData::getRowValue('Control group?', $data), FILTER_VALIDATE_BOOLEAN));
        $model->cohort_size = intval(UploadedData::getRowValue('Cohort size', $data));
        $model->taxonomy_id = $taxonomyId;
        $model->strain_id = $strainId; 
        $model->sex = trim(UploadedData::getRowValue('Sex', $data));
        $model->age_of_start = intval(UploadedData::getRowValue('Start of treatment', $data));
        $model->smoothed_lifespan_last_decile_age = null;
        $model->smoothed_lifespan_median_age = null;
        $model->light_conditions = trim(UploadedData::getRowValue('Light conditions', $data));
        $model->diet_description = trim(UploadedData::getRowValue('Diet description', $data));
        $model->type_of_experiment = trim(UploadedData::getRowValue('Type of experiment', $data)); 
        $model->active_substance_id = $activeSubstanceId; 
        $model->dosage = trim(UploadedData::getRowValue('Dosage', $data)); // todo
        $model->vehicle = trim(UploadedData::getRowValue('Vehicle', $data)); 
        $model->diet_intervention_description = trim(UploadedData::getRowValue('Diet intervention short description', $data)); 
        $model->temperature_unit = UploadedData::getRowValue('Units of temperature', $studyData);
        $model->age_unit = UploadedData::getRowValue('Units of age', $studyData);
        $model->remarks = trim(UploadedData::getRowValue('Remarks', $data)); 
        $model->health_parameters = null;
        $model->timestamp = date('Y-m-d H:i:s');
        if (!$model->save()) {
            var_dump($model->errors);
        }
        
        return $model;
    }

    public function search($params)
    {
        $query = self::find();
        $query->leftJoin('{{%strain}}', '{{%cohort}}.strain_id={{%strain}}.id');

        // add conditions that should always apply here
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'sex' => $this->sex,
            'strain_id' => $this->strain_id,
        ]);

        if(isset($this->age)) {
            if(strpos($this->age, '>') !== false || strpos($this->age, '<') !== false) {
                $age = ltrim($this->age, '><=');
                $operator = str_replace($age, '', $this->age);
                $query->andFilterCompare('age', $age, $operator);
            } else {
                $query->andFilterWhere(['age' => $this->age]);
            }
        }

        $query->andFilterWhere(['like', 'site', $this->site])
            ->andFilterWhere(['like', 'year', $this->year])
            ->andFilterWhere(['like', 'strain.name', $this->searchStrain])
        ;

//        if($this->selectedStrains) {
//            $query->andFilterWhere(['in', 'strain', $this->selectedStrains]);
//        }
//
        return $dataProvider;
    }
}

