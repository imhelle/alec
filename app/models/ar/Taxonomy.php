<?php

namespace app\models\ar;

use Yii;

/**
 * This is the model class for table "taxonomy".
 *
 * @property int $id
 * @property string|null $name model organism latin name by UniProt
 * @property string|null $uniprot_id
 *
 * @property Cohort[] $cohorts
 */
class Taxonomy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%taxonomy}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'uniprot_id'], 'string', 'max' => 255],
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
            'uniprot_id' => Yii::t('app', 'Uniprot ID'),
        ];
    }

    /**
     * Gets query for [[Cohorts]].
     *
     * @return \yii\db\ActiveQuery|CohortQuery
     */
    public function getCohorts()
    {
        return $this->hasMany(Cohort::className(), ['taxonomy_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return TaxonomyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaxonomyQuery(get_called_class());
    }
}
