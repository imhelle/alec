<?php

namespace app\models;

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
 * @property string|null $drug
 * @property string|null $drug_name
 */
class ExperimentOld extends \app\models\ar\ExperimentOld
{
    public $name;

    /**
    * {@inheritdoc}
    */
    public function behaviors()
    {
        return [
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
                    'drug' => 'Drug',
                ];
    }
    
    public static function getDrugs()
    {
        $result = ['Control' => 'Control'];
        $drugs = self::find()
            ->select('drug_name')
            ->groupBy('drug_name')
            ->column();
        foreach ($drugs as $drug) {
            if(!empty($drug)) {
                $result[$drug] = $drug;
            }
        }
        return $result;
    }
    
    public static function getStrains()
    {
        $result = [];
        $strains = self::find()
            ->select('strain')
            ->orderBy('strain asc')
            ->groupBy('strain')
            ->column();
        foreach ($strains as $strain) {
            if(!empty($strain)) {
                $result[$strain] = $strain;
            }
        }
        return $result;
    }
    
    public static function getSources()
    {
        $result = [];
        $strains = self::find()
            ->select('source')
            ->groupBy('source')
            ->column();
        foreach ($strains as $strain) {
            if(!empty($strain)) {
                $result[$strain] = $strain;
            }
        }
        return $result;
    }

}
