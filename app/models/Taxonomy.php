<?php

namespace app\models;

use InvalidArgumentException;

class Taxonomy extends ar\Taxonomy
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

