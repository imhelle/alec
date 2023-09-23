<?php

namespace app\models\ar;

use Yii;

/**
 * This is the model class for table "c_lifespan_key_results".
 *
 * @property int $id
 * @property string $doi
 * @property string $pubmed_id
 * @property string $full_text_url
 * @property string $title
 * @property string $authors
 * @property string $volunteer_name
 * @property string $volunteer_country
 * @property string $intervention
 * @property string $reference cas_number or similar
 * @property string $reference_type cas number, other
 * @property string $interest
 * @property int $intervention_i
 * @property int $n_interventions
 * @property string $way_of_administration
 * @property string $dosage
 * @property float $age_at_start
 * @property string $duration_unit
 * @property string $gender
 * @property string $species
 * @property string $strain
 * @property string $where_in_paper
 * @property float $median_treatment
 * @property float $max_treatment
 * @property int $n_treatment
 * @property float $median_control
 * @property float $max_control
 * @property int $n_control
 * @property string $p_value
 * @property string $comment
 * @property string $timestamp
 * @property int $trust
 * @property float $avg_lifespan_change from DrugAge
 * @property float $max_lifespan_change from DrugAge
 * @property string $significance from DrugAge
 * @property string $source
 */
class LifespanKeyResults extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'c_lifespan_key_results';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['doi', 'pubmed_id', 'full_text_url', 'title', 'authors', 'volunteer_name', 'volunteer_country', 'intervention', 'reference', 'reference_type', 'way_of_administration', 'dosage', 'gender', 'species', 'strain', 'where_in_paper', 'p_value', 'comment', 'timestamp', 'significance', 'source'], 'required'],
            [['doi', 'pubmed_id', 'full_text_url', 'title', 'authors', 'volunteer_name', 'volunteer_country', 'intervention', 'reference', 'reference_type', 'way_of_administration', 'dosage', 'gender', 'species', 'strain', 'where_in_paper', 'p_value', 'comment', 'source'], 'string'],
            [['intervention_i', 'n_interventions', 'n_treatment', 'n_control', 'trust'], 'integer'],
            [['age_at_start', 'median_treatment', 'max_treatment', 'median_control', 'max_control', 'avg_lifespan_change', 'max_lifespan_change'], 'number'],
            [['timestamp'], 'safe'],
            [['interest', 'duration_unit'], 'string', 'max' => 6],
            [['significance'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'doi' => Yii::t('app', 'Doi'),
            'pubmed_id' => Yii::t('app', 'Pubmed ID'),
            'full_text_url' => Yii::t('app', 'Full Text Url'),
            'title' => Yii::t('app', 'Title'),
            'authors' => Yii::t('app', 'Authors'),
            'volunteer_name' => Yii::t('app', 'Volunteer Name'),
            'volunteer_country' => Yii::t('app', 'Volunteer Country'),
            'intervention' => Yii::t('app', 'Intervention'),
            'reference' => Yii::t('app', 'Reference'),
            'reference_type' => Yii::t('app', 'Reference Type'),
            'interest' => Yii::t('app', 'Interest'),
            'intervention_i' => Yii::t('app', 'Intervention I'),
            'n_interventions' => Yii::t('app', 'N Interventions'),
            'way_of_administration' => Yii::t('app', 'Way Of Administration'),
            'dosage' => Yii::t('app', 'Dosage'),
            'age_at_start' => Yii::t('app', 'Age At Start'),
            'duration_unit' => Yii::t('app', 'Duration Unit'),
            'gender' => Yii::t('app', 'Gender'),
            'species' => Yii::t('app', 'Species'),
            'strain' => Yii::t('app', 'Strain'),
            'where_in_paper' => Yii::t('app', 'Where In Paper'),
            'median_treatment' => Yii::t('app', 'Median Treatment'),
            'max_treatment' => Yii::t('app', 'Max Treatment'),
            'n_treatment' => Yii::t('app', 'N Treatment'),
            'median_control' => Yii::t('app', 'Median Control'),
            'max_control' => Yii::t('app', 'Max Control'),
            'n_control' => Yii::t('app', 'N Control'),
            'p_value' => Yii::t('app', 'P Value'),
            'comment' => Yii::t('app', 'Comment'),
            'timestamp' => Yii::t('app', 'Timestamp'),
            'trust' => Yii::t('app', 'Trust'),
            'avg_lifespan_change' => Yii::t('app', 'Avg Lifespan Change'),
            'max_lifespan_change' => Yii::t('app', 'Max Lifespan Change'),
            'significance' => Yii::t('app', 'Significance'),
            'source' => Yii::t('app', 'Source'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return LifespanKeyResultsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LifespanKeyResultsQuery(get_called_class());
    }
}
