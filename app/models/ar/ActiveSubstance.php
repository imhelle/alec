<?php

namespace app\models\ar;

use Yii;

/**
 * This is the model class for table "active_substance".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $pubchem_id
 *
 * @property ExperimentOld[] $experiments
 */
class ActiveSubstance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'active_substance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'pubchem_id'], 'string', 'max' => 255],
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
            'pubchem_id' => Yii::t('app', 'Pubchem ID'),
        ];
    }

    /**
     * Gets query for [[Experiments]].
     *
     * @return \yii\db\ActiveQuery|app\models\ExperimentQuery
     */
    public function getExperiments()
    {
        return $this->hasMany(ExperimentOld::className(), ['active_substance_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ActiveSubstanceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ActiveSubstanceQuery(get_called_class());
    }
}
