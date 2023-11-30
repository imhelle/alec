<?php


namespace app\modules\contribute\models\traits;


use yii\helpers\ArrayHelper;

trait ActiveRecordTrait
{

    public static function getAllNamesAsArray(): array
    {
        $names = self::find()
            ->select(['id', 'name'])
            ->asArray()
            ->all();
        $result = [];
        foreach ($names as $name) {            
            $result[$name['id']] = $name['name'];
        }
        return $result;
    }

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
    


}