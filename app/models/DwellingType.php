<?php

namespace app\models;

use InvalidArgumentException;

class DwellingType extends ar\DwellingType
{
    public static function findOrCreateByName($name): self
    {
       $model = self::find()->where(['name' => $name])->one();
       if(!$model) {
           $model = new self();
           $model->name = $name;
           $model->save();
       }
       return $model;
    }
}

