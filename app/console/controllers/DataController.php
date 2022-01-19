<?php

namespace app\console\controllers;

use app\models\common\GeneToSource;
use app\models\Experiment;
use yii\console\Controller;
use yii\db\Exception;

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
                    $experiment = new Experiment();
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
    
    

}