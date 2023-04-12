<?php

namespace app\models\ar;

use Yii;

/**
 * This is the model class for table "experiment".
 *
 * @property int $id
 * @property string|null $umn
 * @property string|null $site
 * @property int|null $sex
 * @property string|null $status
 * @property int|null $age
 * @property string|null $year
 * @property string|null $group
 * @property string|null $strain
 * @property string|null $source
 */
class ExperimentOld extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%experiment_old}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sex', 'age'], 'integer'],
            [['umn', 'site', 'status', 'year', 'group', 'drug', 'drug_name', 'strain'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'umn' => 'Umn',
            'site' => 'Site',
            'sex' => 'Sex',
            'status' => 'Status',
            'age' => 'Age',
            'year' => 'Year',
            'group' => 'Group',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\ExperimentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\ExperimentQuery(get_called_class());
    }
}
