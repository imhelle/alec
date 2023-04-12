<?php

namespace app\console\controllers;

use app\models\ActiveSubstance;
use app\models\DwellingType;
use app\models\Cohort;
use app\models\ExperimentOld;
use app\models\Lifespan;
use app\models\Strain;
use app\models\Study;
use app\models\Taxonomy;
use yii\console\Controller;
use yii\db\Exception;
use yii\db\Transaction;

class DataController extends Controller
{
    public function actionLoadCsv($fullPath)
    {
        if (!file_exists($fullPath)) {
            echo 'Cannot find data file' . PHP_EOL;
        }
        $f = fopen($fullPath, 'r');
        
        try {
            $counter = 0;
            while (($data = fgetcsv($f)) !== false) {
                if ($data[10] === "0") {
                    $experiment = new ExperimentOld();
                    $experiment->drug = 'Control';
                    $experiment->drug_name = 'Control';
                    $experiment->group = 'Controls';
                    $experiment->umn = $data[8];
                    $experiment->sex = $data[3] == 'F' ? 0 : 1;
                    $experiment->age = $data[11];
                    $experiment->strain = $data[0];
                    $experiment->source = 'PMID:19627267';
                    $dateArray = explode('/', $data[4]);
                    if (isset($dateArray[2])) {
                        $experiment->year = $dateArray[2];
                    } else {
                        throw new Exception('Wrong date: ' . var_export($dateArray, true));
                    }
                    $experiment->year = 'C20' . explode('/', $dateArray[2]);
                    $experiment->status = 'Dead';
                    $experiment->site = 'TJL';
                    $experiment->save();
                    $counter++;
                    echo $counter . PHP_EOL;
                }
            }
        } catch (\Exception $e) {
            echo $e->getMessage() . PHP_EOL . $e->getTraceAsString() . PHP_EOL;
        }
        
    }
    
    public function actionMigrateData($from = 1)
    {
        $oldExperiments = ExperimentOld::find()->groupBy(['drug', 'year', '`group`', 'sex', 'site'])
            ->all();
        $dwellingId = DwellingType::findOrCreateByName('cage')->id;
        $taxonomyId = Taxonomy::findOrCreateByName('mouse')->id;
//        echo $from; die;
        $counter = 0;
        foreach ($oldExperiments as $oldExperiment) {
            $counter++;
            if ($counter < $from) {
                continue;
            }
            $transaction = \Yii::$app->db->beginTransaction();
            $study = new Study();
            $study->remarks = $oldExperiment->drug . ' '
                . $oldExperiment->source . ' ' 
                . $oldExperiment->year . ' ' 
                . $oldExperiment->sex . ' ' 
                . $oldExperiment->site . ' ' 
                . $oldExperiment->group;
            $study->timestamp = date('Y-m-d H:i:s');
            $study->save();
            echo PHP_EOL . $study->remarks . ' ';
            
            
            $cohort = new Cohort();
            $cohort->study_id = $study->id;
            $cohort->dwelling_id = $dwellingId;
            $cohort->control = $oldExperiment->group == 'Controls' ? 1 : 0;
            $cohort->taxonomy_id = $taxonomyId;
            $cohort->site = $oldExperiment->site;
            $cohort->strain_id = Strain::findOrCreateByNameAndTax($oldExperiment->strain, $taxonomyId)->id;
            $cohort->sex = $oldExperiment->sex == 0 ? 'female' : 'male';
            $cohort->active_substance_id = ActiveSubstance::findOrCreateByName($oldExperiment->drug)->id;
            $cohort->year = (integer)ltrim($oldExperiment->year, 'C');
            $cohort->remarks = $oldExperiment->drug . ' '
                . $oldExperiment->source . ' '
                . $oldExperiment->year . ' '
                . $oldExperiment->sex . ' '
                . $oldExperiment->site . ' '
                . $oldExperiment->group;
            $cohort->timestamp = date('Y-m-d H:i:s'); 
            $cohort->save();
            if(!$cohort->save()) {
                var_dump($cohort->errors);
                $transaction->rollBack();
                exit();
            }
            
            $ages = ExperimentOld::find()->select('age')->where([
                'drug' => $oldExperiment->drug,
                'year' => $oldExperiment->year,
                '`group`' => $oldExperiment->group,
                'sex' => $oldExperiment->sex,
                'site' => $oldExperiment->site,
            ])->column();
            
            foreach ($ages as $age) {
                $lifespan = new Lifespan();
                $lifespan->age = $age;
                $lifespan->cohort_id = $cohort->id;
                $lifespan->save();
            }
            echo count($ages) . ' ' . $counter;
            $transaction->commit();
            
        }
    }
    
    

}