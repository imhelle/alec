<?php

namespace app\models;

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
            throw new InvalidArgumentException('Upload error');
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
        foreach ($this->experimentFiles as $file) {
            $experiment = new Cohort();
            $experiment->loadFromFile($file);
        }
    }
}

# 9633030244