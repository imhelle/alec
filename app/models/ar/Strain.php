<?php

namespace app\models\ar;

use Yii;

/**
 * This is the model class for table "strain".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $taxonomy_id
 *
 * @property Experiment[] $experiments
 */
class Strain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'strain';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'taxonomy_id'], 'string', 'max' => 255],
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
            'taxonomy_id' => Yii::t('app', 'Taxonomy ID'),
        ];
    }

    /**
     * Gets query for [[Experiments]].
     *
     * @return \yii\db\ActiveQuery|ExperimentQuery
     */
    public function getExperiments()
    {
        return $this->hasMany(Experiment::className(), ['strain_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return StrainQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StrainQuery(get_called_class());
    }
}
