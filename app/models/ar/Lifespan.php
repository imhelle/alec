<?php

namespace app\models\ar;

use Yii;

/**
 * This is the model class for table "lifespan".
 *
 * @property int $id
 * @property int|null $cohort_id
 * @property int|null $age age of death or removal of the animal, one per cell, in age_unit defined in cohort
 * @property string|null $status dead or removed
 * @property string|null $health_measures health parameters that are key for lifespan interpretation, as indicated in cohort_lifespans, separated by commas. ex: weight of the animal to judge for crypto-caloric restriction
 *
 * @property Cohort $cohort
 */
class Lifespan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%lifespan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cohort_id', 'age'], 'integer'],
            [['health_measures'], 'string'],
            [['status'], 'string', 'max' => 255],
            [['cohort_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cohort::className(), 'targetAttribute' => ['cohort_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cohort_id' => Yii::t('app', 'Cohort ID'),
            'age' => Yii::t('app', 'Age'),
            'status' => Yii::t('app', 'Status'),
            'health_measures' => Yii::t('app', 'Health Measures'),
        ];
    }

    /**
     * Gets query for [[Cohort]].
     *
     * @return \yii\db\ActiveQuery|CohortQuery
     */
    public function getCohort()
    {
        return $this->hasOne(Cohort::className(), ['id' => 'cohort_id']);
    }

    /**
     * {@inheritdoc}
     * @return LifespanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LifespanQuery(get_called_class());
    }
}
