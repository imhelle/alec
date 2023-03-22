<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ExperimentOld;

/**
 * ExperimentSearch represents the model behind the search form of `\app\models\Experiment`.
 */
class ExperimentSearch extends ExperimentOld
{
    
    public $selectedStrains = [];
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sex'], 'integer'],
            [['umn', 'site', 'status', 'year', 'group', 'drug', 'drug_name', 'age', 'strain',  'source', 'selectedStrains'], 'safe'],
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
        $query = ExperimentOld::find();

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

        $query->andFilterWhere(['like', 'umn', $this->umn])
            ->andFilterWhere(['like', 'site', $this->site])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'year', $this->year])
            ->andFilterWhere(['like', 'drug', $this->drug])
            ->andFilterWhere(['like', 'drug_name', $this->drug_name])
            ->andFilterWhere(['like', 'strain', $this->strain])
            ->andFilterWhere(['like', 'source', $this->source])
        ;
        
//        if($this->selectedStrains) {
//            $query->andFilterWhere(['in', 'strain', $this->selectedStrains]);
//        }
//        
        
        if(isset($this->group)) {
            switch ($this->group) {
                case ('cont'): $query->andFilterWhere(['group' => 'Controls']); break;
                case ('cont_nodrug'): $query->andFilterWhere(['group' => ['Controls', 'Nodrug']]); break;
                case ('nodrug'): $query->andFilterWhere(['group' => 'Nodrug']); break;
                case ('drug'): $query->andFilterWhere(['group' => 'Drug']); break;
            }
        }

        return $dataProvider;
    }
}
