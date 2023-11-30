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
//            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @param UploadedFile[] $files
     * @return void
     */
    public function setExperimentFiles(array $files)
    {
        if (!$files) {
            throw new InvalidArgumentException('Upload error, no files uploaded');
        }
        $fileDir = $this->createDirectory();
        foreach ($files as $file) {
            $file->saveAs($fileDir . '/' . $file->name, false); // save files anyway for debug
            $fileNumber = $this->getFileNumber($file);
            if (strpos($file->name, 'study') !== false) {
                $this->studyFile = $file;
            } elseif (strpos($file->name, 'experiment') !== false) {
                $this->experimentFiles[$fileNumber] = $file;
            } elseif (strpos($file->name, 'lifespan') !== false) {
                $this->lifespanFiles[$fileNumber] = $file;
            }
        }
        $this->checkFiles();
    }
    
    private function createDirectory(): string
    {
        $userId = \Yii::$app->user->getIsGuest() ? 'guest_' . \Yii::$app->request->userIP : \Yii::$app->user->id;
        $fileDir = rtrim(\Yii::getAlias('@app'), '/') . '/uploads/' . $userId . '/' . date('d_m_Y_') . time();
        mkdir($fileDir, 0777, true);
        return $fileDir;
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

    public function checkFiles()
    {
//        if (!$this->files) {
//            throw new InvalidArgumentException('Upload error, no files uploaded');
//        }
//        var_dump($this->studyFile);
        if (!$this->studyFile) {
            throw new InvalidArgumentException('No study file provided');
        }
        
        foreach ($this->experimentFiles as $number => $file) {
            if (!isset($this->lifespanFiles[$number])) {
                throw new InvalidArgumentException("No lifespan file for experiment {$number} provided");
            }
        }
        foreach ($this->lifespanFiles as $number => $file) {
            if (!isset($this->experimentFiles[$number])) {
                throw new InvalidArgumentException("No experiment file for lifespan {$number} provided");
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
            $cohort = Cohort::saveFromUploadedData($cohortData, $study->id, $studyData);
            
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