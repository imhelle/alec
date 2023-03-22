<?php

namespace app\models\ar;

use Yii;

/**
 * This is the model class for table "study".
 *
 * @property int $id
 * @property string|null $email
 * @property string|null $journal
 * @property string|null $authors
 * @property int|null $year
 * @property string|null $doi
 * @property string|null $pmid
 * @property int|null $taxonomy_id
 * @property int|null $strain_id
 * @property string|null $temperature_unit
 * @property string|null $age_unit
 * @property string|null $remarks
 *
 * @property Experiment[] $experiments
 */
class Study extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'study';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year', 'taxonomy_id', 'strain_id'], 'integer'],
            [['remarks'], 'string'],
            [['email', 'journal', 'authors', 'doi', 'pmid', 'temperature_unit', 'age_unit'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'email' => Yii::t('app', 'Email'),
            'journal' => Yii::t('app', 'Journal'),
            'authors' => Yii::t('app', 'Authors'),
            'year' => Yii::t('app', 'Year'),
            'doi' => Yii::t('app', 'Doi'),
            'pmid' => Yii::t('app', 'Pmid'),
            'taxonomy_id' => Yii::t('app', 'Taxonomy ID'),
            'strain_id' => Yii::t('app', 'Strain ID'),
            'temperature_unit' => Yii::t('app', 'Temperature Unit'),
            'age_unit' => Yii::t('app', 'Age Unit'),
            'remarks' => Yii::t('app', 'Remarks'),
        ];
    }

    /**
     * Gets query for [[Experiments]].
     *
     * @return \yii\db\ActiveQuery|ExperimentQuery
     */
    public function getExperiments()
    {
        return $this->hasMany(Experiment::className(), ['study_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return StudyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StudyQuery(get_called_class());
    }
}
