<?php

namespace app\modules\contribute\models;

use app\modules\contribute\models\traits\ActiveRecordTrait;

class Cohort extends \app\models\Cohort
{
    public $plainLifespans;
    use ActiveRecordTrait;
    
    public function getLifespansArray(): array
    {
        return Lifespan::find()
            ->select('age')
            ->where(['cohort_id' => $this->id])
            ->column();
    }
}

