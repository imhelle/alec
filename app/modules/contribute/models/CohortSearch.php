<?php

namespace app\modules\contribute\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CohortSearch represents the model behind the search form of `app\models\Cohort`.
 */
class CohortSearch extends Cohort
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'study_id', 'dwelling_id', 'animals_per_dwelling', 'control', 'cohort_size', 'taxonomy_id', 'strain_id', 'active_substance_id', 'year', 'enabled', 'collida_id', 'user_id'], 'integer'],
            [['temperature', 'site', 'sex', 'light_conditions', 'diet_description', 'type_of_experiment', 'dosage', 'vehicle', 'diet_intervention_description', 'temperature_unit', 'age_unit', 'remarks', 'health_parameters', 'timestamp', 'comment', 'source'], 'safe'],
            [['age_of_start', 'smoothed_lifespan_last_decile_age', 'smoothed_lifespan_median_age'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Cohort::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'study_id' => $this->study_id,
            'dwelling_id' => $this->dwelling_id,
            'animals_per_dwelling' => $this->animals_per_dwelling,
            'control' => $this->control,
            'cohort_size' => $this->cohort_size,
            'taxonomy_id' => $this->taxonomy_id,
            'strain_id' => $this->strain_id,
            'age_of_start' => $this->age_of_start,
            'smoothed_lifespan_last_decile_age' => $this->smoothed_lifespan_last_decile_age,
            'smoothed_lifespan_median_age' => $this->smoothed_lifespan_median_age,
            'active_substance_id' => $this->active_substance_id,
            'year' => $this->year,
            'timestamp' => $this->timestamp,
            'enabled' => $this->enabled,
            'collida_id' => $this->collida_id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'temperature', $this->temperature])
            ->andFilterWhere(['like', 'site', $this->site])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'light_conditions', $this->light_conditions])
            ->andFilterWhere(['like', 'diet_description', $this->diet_description])
            ->andFilterWhere(['like', 'type_of_experiment', $this->type_of_experiment])
            ->andFilterWhere(['like', 'dosage', $this->dosage])
            ->andFilterWhere(['like', 'vehicle', $this->vehicle])
            ->andFilterWhere(['like', 'diet_intervention_description', $this->diet_intervention_description])
            ->andFilterWhere(['like', 'temperature_unit', $this->temperature_unit])
            ->andFilterWhere(['like', 'age_unit', $this->age_unit])
            ->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'health_parameters', $this->health_parameters])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'source', $this->source]);

        return $dataProvider;
    }
}
