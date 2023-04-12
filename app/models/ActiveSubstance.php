<?php

namespace app\models;

use InvalidArgumentException;
use yii\helpers\ArrayHelper;

class ActiveSubstance extends ar\ActiveSubstance
{

    public static function getList()
    {
        $data = self::find()->all();
        return ArrayHelper::map($data, 'id', 'name');
    }
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

    public static function getName($id)
    {
        return self::find()->where(['id' => $id])->select('name')->scalar();
    }
}

