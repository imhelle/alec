<?php

namespace app\models;

use InvalidArgumentException;
use yii\helpers\ArrayHelper;

class Strain extends ar\Strain
{
    
    public static function getList()
    {
        $data = self::find()->all();
        return ArrayHelper::map($data, 'id', 'name');
    }
    
    public static function findOrCreateByNameAndTax($name, $taxonomyId): self
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

