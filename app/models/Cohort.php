<?php

namespace app\models;

use moonland\phpexcel\Excel;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

class Cohort extends ar\Cohort
{
    public $searchStudy;
    private $lifespanValues;

    public static function getActiveCount()
    {
        return self::find()->where(['enabled' => 1])->count();
    }

    public static function saveFromUploadedData($data, $studyId, $studyData): Cohort
    {
        $dwellingId = DwellingType::findOrCreateByName(UploadedData::getRowValue('Type of dwelling', $data))->id;
        $taxonomyId = Taxonomy::findOrCreateByNameAndUniprot(
            UploadedData::getRowValue('Taxonomy name', $data),
            UploadedData::getRowValue('Taxonomy ID', $data)
        )->id;
        $strainId = Strain::findOrCreateByNameAndTax(UploadedData::getRowValue('Strain', $data), $taxonomyId)->id;
        $activeSubstanceId = ActiveSubstance::findOrCreateByName(UploadedData::getRowValue('Active substance name', $data))->id;
        $userId = \Yii::$app->user->getIsGuest() ? 'guest_' . \Yii::$app->request->userIP : \Yii::$app->user->id;

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
        $model->user_id = $userId;
        $model->source = 'upload';
        if (!$model->save()) {
            var_dump($model->errors);
        }

        return $model;
    }

    public function search($params)
    {
        $query = self::find()->where(['enabled' => 1]);
        $query->leftJoin('{{%strain}}', '{{%cohort}}.strain_id={{%strain}}.id');
        $query->leftJoin('{{%study}}', '{{%cohort}}.study_id={{%study}}.id');

        // add conditions that should always apply here

        $this->load($params);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'sex' => $this->sex,
            'strain_id' => $this->strain_id,
//            'year' => $this->year,
        ]);

        if (isset($this->age)) {
            if (strpos($this->age, '>') !== false || strpos($this->age, '<') !== false) {
                $age = ltrim($this->age, '><=');
                $operator = str_replace($age, '', $this->age);
                $query->andFilterCompare('age', $age, $operator);
            } else {
                $query->andFilterWhere(['age' => $this->age]);
            }
        }

        if ($this->active_substance_id === '0') {
//            $query->andWhere('{{%cohort}}.active_substance_id is null');
            $query->andWhere(['active_substance_id' => null]);
        } else {
            $query->andFilterWhere(['active_substance_id' => $this->active_substance_id]);
        }

        if ($this->dosage) {
            $this->dosage = str_replace(',', '.', $this->dosage);
        }
        $query->andFilterWhere(['like', 'site', $this->site])
            ->andFilterWhere(['like', '{{%cohort}}.year', $this->year])
            ->andFilterWhere(['like', 'dosage', $this->dosage])
            ->andFilterWhere(['like', '{{%cohort}}.remarks', $this->remarks])
            ->andFilterWhere(['like', 'age_of_start', $this->age_of_start]);
//        var_dump($query); die;

//        if($this->selectedStrains) {
//            $query->andFilterWhere(['in', 'strain', $this->selectedStrains]);
//        }
//

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }

    public function getMinLifespan()
    {
        return min($this->getLifespanValues());
    }

    public function getMedLifespan()
    {
        $lifespans = $this->getLifespanValues();
        arsort($lifespans);
        $keys = array_keys($lifespans);
        return $lifespans[round(count($keys) / 2)];
    }

    public function getMaxLifespan()
    {
        return max($this->getLifespanValues());
    }

    public function getLifespanValues()
    {
        if (!$this->lifespanValues) {
            $this->lifespanValues = Lifespan::find()
                ->where(['cohort_id' => $this->id])
                ->select('age')
                ->orderBy('age')
                ->column();
        }
        return $this->lifespanValues;
    }

    public static function buildLabelByQuery($query): string
    {
        
        if ($query == " (`enabled`=1) AND (`active_substance_id` IS NULL)") {
            return 'All controls';
        }
        $label = trim(str_replace(['`', '%', '(', ')', '\''], '', $query));
        $label = str_replace([' AND '], ', ', $label);
        $label = str_replace([' LIKE '], '=', $label);

        preg_match('/strain_id=(\d+)/', $label, $strainMatches);
        preg_match('/active_substance_id=(\d+)/', $label, $substanceMatches);
        preg_match('/age_of_start=(\d+)/', $label, $startMatches);
        preg_match('/year=(\d+)/', $label, $yearMatches);
        preg_match('/sex=([^,]+)/', $label, $sexMatches);
        preg_match('/site=([^,]+)/', $label, $siteMatches);
        preg_match('/dosage=[^,]*(,|$)/', $label, $dosageMatches);

        $labelArray = [];
        if ($strainMatches) {
            $strainName = Strain::getName($strainMatches[1]);
            $labelArray[] = $strainName;
        }
        if ($sexMatches) {
            $labelArray[] = ucfirst($sexMatches[1]);
        }
        if (strpos($label, 'active_substance_id IS NULL') !== false) {
            $labelArray[] = 'Control';
        }
        if ($substanceMatches) {
            $substanceName = ActiveSubstance::getName($substanceMatches[1]);
            $labelArray[] = $substanceName;
        }
        if ($startMatches | $dosageMatches) {
            $cohorts = self::find()
                ->where($query)
                ->orderBy('age_of_start desc')
                ->select(['age_of_start', 'age_unit', 'dosage'])
                ->asArray()
                ->all();
            $ages = [];
            $dosages = [];
            foreach ($cohorts as $cohort) {
                $age = $cohort['age_of_start'] . ' ' . $cohort['age_unit'];
                $ages[$age] = $age;
                $dosages[$cohort['dosage']] = $cohort['dosage'];
            }
            if ($dosageMatches) {
                $labelArray[] = implode(', ', $dosages);
            }
            if ($startMatches) {
                $starts = implode(', ', $ages);
                $labelArray[] = "from {$starts}";
            }
        }
        if ($yearMatches) {
            $labelArray[] = $yearMatches[1];
        }
        if ($siteMatches) {
            $labelArray[] = $siteMatches[1];
        }
        $label = implode(', ', $labelArray);
        return !$label ? 'All' : $label;
    }
    
    public static function getDataFromQuery($query)
    {
        return self::find()
            ->leftJoin('{{%lifespan}}', '{{%lifespan}}.cohort_id={{%cohort}}.id')
            ->leftJoin('{{%strain}}', '{{%cohort}}.strain_id={{%strain}}.id')
            ->select('{{%lifespan}}.age')
            ->where($query)
            ->orderBy('age desc')
            ->column();
    }
    
    public static function buildLabelById($cohortId)
    {
        $labelArray =  self::find()
            ->select(['{{%study}}.pubmed_id', 
                '{{%strain}}.name strain_name', '{{%cohort}}.sex', '{{%active_substance}}.name substance_name', 
                '{{%cohort}}.sex', '{{%cohort}}.dosage', 'site'])
            ->leftJoin('{{%study}}', '{{%cohort}}.study_id={{%study}}.id')
            ->leftJoin('{{%strain}}', '{{%cohort}}.strain_id={{%strain}}.id')
            ->leftJoin('{{%active_substance}}', '{{%cohort}}.active_substance_id={{%active_substance}}.id')
            ->where(['{{%cohort}}.id' => $cohortId])
            ->asArray()
            ->one();
        
        if(!$labelArray['substance_name']) {
            $labelArray['substance_name'] = 'Control';
        }
        
        if(!$labelArray['substance_name']) {
            $labelArray['substance_name'] = 'Control';
        }

        $labelArray['pubmed_id'] = 'PMID ' . $labelArray['pubmed_id'];
        $labelArray['sex'] = ucfirst($labelArray['sex']);
        
        return (implode(array_filter($labelArray), ', '));
    }
    
    public static function getLifespansArray($id)
    {
        $lifespans = array_map('intval', Lifespan::find()->where(['cohort_id' => $id])->select('age')->column());
        arsort($lifespans);
        return array_values($lifespans);
    }
}

