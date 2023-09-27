<?php

namespace app\models\ar;

use Yii;

/**
 * This is the model class for table "cohort".
 *
 * @property int $id
 * @property int|null $study_id
 * @property string|null $temperature
 * @property int|null $dwelling_id
 * @property int|null $animals_per_dwelling
 * @property int|null $control
 * @property int|null $cohort_size
 * @property int|null $taxonomy_id
 * @property int|null $strain_id
 * @property string|null $site place of the experiment
 * @property string|null $sex
 * @property float|null $age_of_start age at start of treatment
 * @property float|null $smoothed_lifespan_last_decile_age 10% of the animals are alive for smoothed survival curve
 * @property float|null $smoothed_lifespan_median_age 50% of the animals are alive for smoothed survival curve
 * @property string|null $light_conditions in hours, light:dark ("10:14")
 * @property string|null $diet_description
 * @property string|null $type_of_experiment drug / genetic / diet / other
 * @property int|null $active_substance_id
 * @property int|null $year
 * @property string|null $dosage including units and timeliness. Examples of timeliness to favor a common language: once initially, every other week, continuously
 * @property string|null $vehicle
 * @property string|null $diet_intervention_description
 * @property string|null $temperature_unit
 * @property string|null $age_unit
 * @property string|null $remarks
 * @property string|null $health_parameters names of health parameters (filled in individual_lifespans), separated by commas
 * @property string|null $timestamp
 * @property string|null $source
 * @property int|null $collida_id
 * @property int|null $user_id
 *
 * @property ActiveSubstance $activeSubstance
 * @property DwellingType $dwelling
 * @property Strain $strain
 * @property Study $study
 * @property Taxonomy $taxonomy
 * @property Lifespan[] $lifespans
 */
class Cohort extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cohort}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['study_id', 'dwelling_id', 'animals_per_dwelling', 'control', 'cohort_size', 'taxonomy_id', 'strain_id', 'active_substance_id'], 'integer'],
            [['age_of_start', 'year', 'smoothed_lifespan_last_decile_age', 'smoothed_lifespan_median_age'], 'number'],
            [['diet_description', 'diet_intervention_description', 'remarks', 'health_parameters'], 'string'],
            [['timestamp', 'study'], 'safe'],
            [['temperature', 'site', 'sex', 'light_conditions', 'type_of_experiment', 'dosage', 'vehicle', 'temperature_unit', 'age_unit'], 'string', 'max' => 255],
            [['active_substance_id'], 'exist', 'skipOnError' => true, 'targetClass' => ActiveSubstance::className(), 'targetAttribute' => ['active_substance_id' => 'id']],
            [['dwelling_id'], 'exist', 'skipOnError' => true, 'targetClass' => DwellingType::className(), 'targetAttribute' => ['dwelling_id' => 'id']],
            [['strain_id'], 'exist', 'skipOnError' => true, 'targetClass' => Strain::className(), 'targetAttribute' => ['strain_id' => 'id']],
            [['study_id'], 'exist', 'skipOnError' => true, 'targetClass' => Study::className(), 'targetAttribute' => ['study_id' => 'id']],
            [['taxonomy_id'], 'exist', 'skipOnError' => true, 'targetClass' => Taxonomy::className(), 'targetAttribute' => ['taxonomy_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'study_id' => Yii::t('app', 'Study ID'),
            'temperature' => Yii::t('app', 'Temperature'),
            'dwelling_id' => Yii::t('app', 'Dwelling ID'),
            'animals_per_dwelling' => Yii::t('app', 'Animals Per Dwelling'),
            'control' => Yii::t('app', 'Control'),
            'cohort_size' => Yii::t('app', 'Cohort Size'),
            'taxonomy_id' => Yii::t('app', 'Taxonomy ID'),
            'strain_id' => Yii::t('app', 'Strain ID'),
            'site' => Yii::t('app', 'Site'),
            'sex' => Yii::t('app', 'Sex'),
            'age_of_start' => Yii::t('app', 'Age Of Start'),
            'smoothed_lifespan_last_decile_age' => Yii::t('app', 'Smoothed Lifespan Last Decile Age'),
            'smoothed_lifespan_median_age' => Yii::t('app', 'Smoothed Lifespan Median Age'),
            'light_conditions' => Yii::t('app', 'Light Conditions'),
            'diet_description' => Yii::t('app', 'Diet Description'),
            'type_of_experiment' => Yii::t('app', 'Type Of Experiment'),
            'active_substance_id' => Yii::t('app', 'Active Substance ID'),
            'dosage' => Yii::t('app', 'Dosage'),
            'vehicle' => Yii::t('app', 'Vehicle'),
            'diet_intervention_description' => Yii::t('app', 'Diet Intervention Description'),
            'temperature_unit' => Yii::t('app', 'Temperature Unit'),
            'age_unit' => Yii::t('app', 'Age Unit'),
            'remarks' => Yii::t('app', 'Remarks'),
            'health_parameters' => Yii::t('app', 'Health Parameters'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }

    /**
     * Gets query for [[ActiveSubstance]].
     *
     * @return \yii\db\ActiveQuery|ActiveSubstanceQuery
     */
    public function getActiveSubstance()
    {
        return $this->hasOne(ActiveSubstance::className(), ['id' => 'active_substance_id']);
    }

    /**
     * Gets query for [[Dwelling]].
     *
     * @return \yii\db\ActiveQuery|DwellingTypeQuery
     */
    public function getDwelling()
    {
        return $this->hasOne(DwellingType::className(), ['id' => 'dwelling_id']);
    }

    /**
     * Gets query for [[Strain]].
     *
     * @return \yii\db\ActiveQuery|StrainQuery
     */
    public function getStrain()
    {
        return $this->hasOne(Strain::className(), ['id' => 'strain_id']);
    }

    /**
     * Gets query for [[Study]].
     *
     * @return \yii\db\ActiveQuery|StudyQuery
     */
    public function getStudy()
    {
        return $this->hasOne(Study::className(), ['id' => 'study_id']);
    }

    /**
     * Gets query for [[Taxonomy]].
     *
     * @return \yii\db\ActiveQuery|TaxonomyQuery
     */
    public function getTaxonomy()
    {
        return $this->hasOne(Taxonomy::className(), ['id' => 'taxonomy_id']);
    }

    /**
     * Gets query for [[Lifespans]].
     *
     * @return \yii\db\ActiveQuery|LifespanQuery
     */
    public function getLifespans()
    {
        return $this->hasMany(Lifespan::className(), ['cohort_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return CohortQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CohortQuery(get_called_class());
    }
}
