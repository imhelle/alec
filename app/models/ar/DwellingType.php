<?php

namespace app\models\ar;

use Yii;

/**
 * This is the model class for table "dwelling_type".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property Cohort[] $cohorts
 */
class DwellingType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dwelling_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * Gets query for [[Cohorts]].
     *
     * @return \yii\db\ActiveQuery|CohortQuery
     */
    public function getCohorts()
    {
        return $this->hasMany(Cohort::className(), ['dwelling_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return DwellingTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DwellingTypeQuery(get_called_class());
    }
}
