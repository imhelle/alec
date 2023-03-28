<?php

namespace app\models;

use moonland\phpexcel\Excel;
use yii\base\InvalidArgumentException;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadedData extends Model
{
    /**
     * @var UploadedFile[]|Null file attribute
     */
    public $files;
    /**
     * @var UploadedFile|Null
     */
    private $studyFile;
    /**
     * @var UploadedFile[]|Null
     */
    private $experimentFiles;
    /**
     * @var UploadedFile[]|Null
     */
    private $lifespanFiles;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['files'], 'file', 'minFiles' => 3, 'maxFiles' => 0],
            [['files'], 'filesCount'],
        ];
    }
    
    public function setExperimentFiles($files)
    {
        if (!$files) {
            throw new InvalidArgumentException('Upload error, no files uploaded');
        }
        foreach ($files as $file) {
            $fileNumber = $this->getFileNumber($file);
            if (strpos($file->name, 'study') !== false) {
                $this->studyFile = $file;
            } elseif (strpos($file->name, 'experiment') !== false) {
                $this->experimentFiles[$fileNumber] = $file;
            } elseif (strpos($file->name, 'lifespan') !== false) {
                $this->lifespanFiles[$fileNumber] = $file;
            }
        }
    }
    
    private function getFileNumber(UploadedFile $file) {
        $fileNameArray = explode('_', explode('.', $file->name)[0]);
        if (count($fileNameArray) == 1 && $fileNameArray[0] == 'study') {
            return 0;
        }
        if (count($fileNameArray) > 2 || !is_numeric($fileNameArray[1])) {
            throw new InvalidArgumentException('Invalid filename ' . $file->name);
        }
        return $fileNameArray[1];
    }

    public function filesCount()
    {
        if (!$this->studyFile) {
            throw new InvalidArgumentException('No study file provided');
        }
        
        foreach ($this->experimentFiles as $number => $file) {
            if (!isset($this->lifespanFiles[$number])) {
                throw new InvalidArgumentException('No lifespan file for experiment ' . $number);
            }
        }
        foreach ($this->lifespanFiles as $number => $file) {
            if (!isset($this->experimentFiles[$number])) {
                throw new InvalidArgumentException('No experiment file for lifespan ' . $number);
            }
        }

    }
    
    public function importToDb()
    {
        $studyData = Excel::import($this->studyFile->tempName, [
            'setFirstRecordAsKeys' => false
        ]);
        $study = Study::getRecordByData($studyData);
        foreach ($this->experimentFiles as $number => $file) {
//            echo json_encode(['message' => count($this->experimentFiles)]);
            $cohortData = Excel::import($file->tempName, [
                'setFirstRecordAsKeys' => false
            ]);
            $cohort = Cohort::saveFromData($cohortData, $study->id);
            
            $lifespanFile = $this->lifespanFiles[$number];
            $lifespanData = Excel::import($lifespanFile->tempName, [
                'setFirstRecordAsKeys' => false
            ]);
            Lifespan::saveMultipleFromData($lifespanData, $cohort->id);
        }
    }
    
    public static function getRowValue($row, $data)
    {
        foreach ($data as $item) {
            if (stripos($item['A'], $row) === 0) {
                return $item['B'];
            }
        }
        return null;
    }
}

# 9633030244