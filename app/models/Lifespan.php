<?php

namespace app\models;

use InvalidArgumentException;

class Lifespan extends ar\Lifespan
{
    
    public static function getActiveCount()
    {
        return self::find()
            ->leftJoin('{{%cohort}}', '{{%lifespan}}.cohort_id={{%cohort}}.id')
            ->select('{{%lifespan}}.id')->distinct()->count();
    }
    public static function saveMultipleFromData($data, $cohortId)
    {
        if (!isset($data[1]['A'])) {
            throw new InvalidArgumentException('Invalid lifespan data ' . var_export($data, true));
        }
        if (stripos($data[1]['A'], 'Age') !== false) {
            array_shift($data);
        }
        foreach ($data as $item) {
            if ($item['A'] == null) {
                break;
            }
            $model = new self();
            $model->cohort_id = $cohortId;
            $model->age = $item['A'];
            $model->save();
        }
    }
}

