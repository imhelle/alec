<?php

namespace app\modules\contribute\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Study;

/**
 * StudySearch represents the model behind the search form of `app\models\Study`.
 */
class StudySearch extends Study
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'year'], 'integer'],
            [['journal', 'doi', 'pubmed_id', 'full_text_URL', 'email', 'authors', 'remarks', 'timestamp'], 'safe'],
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
        $query = Study::find();

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
            'year' => $this->year,
            'timestamp' => $this->timestamp,
        ]);

        $query->andFilterWhere(['like', 'journal', $this->journal])
            ->andFilterWhere(['like', 'doi', $this->doi])
            ->andFilterWhere(['like', 'pubmed_id', $this->pubmed_id])
            ->andFilterWhere(['like', 'full_text_URL', $this->full_text_URL])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'authors', $this->authors])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
