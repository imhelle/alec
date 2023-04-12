<?php

namespace app\models\ar;

use Yii;

/**
 * This is the model class for table "study".
 *
 * @property int $id
 * @property string|null $journal
 * @property string|null $doi
 * @property string|null $pubmed_id -1 if not found
 * @property string|null $full_text_URL for free articles
 * @property string|null $email submitter's email
 * @property string|null $authors authors names separated by comma
 * @property int|null $year
 * @property string|null $remarks
 * @property string|null $timestamp
 *
 * @property Cohort[] $cohorts
 */
class Study extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%study}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year'], 'integer'],
            [['remarks'], 'string'],
            [['timestamp'], 'safe'],
            [['journal', 'doi', 'pubmed_id', 'full_text_URL', 'email', 'authors'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'journal' => Yii::t('app', 'Journal'),
            'doi' => Yii::t('app', 'Doi'),
            'pubmed_id' => Yii::t('app', 'Pubmed ID'),
            'full_text_URL' => Yii::t('app', 'Full Text Url'),
            'email' => Yii::t('app', 'Email'),
            'authors' => Yii::t('app', 'Authors'),
            'year' => Yii::t('app', 'Year'),
            'remarks' => Yii::t('app', 'Remarks'),
            'timestamp' => Yii::t('app', 'Timestamp'),
        ];
    }

    /**
     * Gets query for [[Cohorts]].
     *
     * @return \yii\db\ActiveQuery|CohortQuery
     */
    public function getCohorts()
    {
        return $this->hasMany(Cohort::className(), ['study_id' => 'id']);
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
