<?php

namespace app\models;

use app\models\ar\Experiment;
use app\models\ar\ExperimentQuery;
use app\models\ar\StudyQuery;
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
class Study extends \app\models\ar\Study
{
    public function loadFromXLSX($xlsxArray)
    {
        if ($xlsxArray[0] == 'email') {
            $this->email = $xlsxArray[0]['B']
        }
    }
        public function attributeLabels()
    {
        return [
            'doi' => Yii::t('app', 'DOI'),
            'pmid' => Yii::t('app', 'PMID'),
        ];
    }

}
