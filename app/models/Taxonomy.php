<?php

namespace app\models;

use InvalidArgumentException;

class Taxonomy extends ar\Taxonomy
{
    public static function findOrCreateByName($name)
    {
       $model = self::find()->where(['name' => $name])->one();
       if(!$model) {
           $model = new self();
           $model->name = $name;
           $model->save();
       }
       return $model;
    }

    public static function findOrCreateByNameAndUniprot($name, $uniprotId)
    {
        $model = self::find()->where(['uniprot_id' => $uniprotId])->one();
        if(!$model) {
            $model = new self();
            $model->name = $name;
            $model->uniprot_id = $uniprotId;
            $model->save();
        }
        return $model;
    }
}

