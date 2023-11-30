<?php

namespace app\modules\contribute\models;

use app\modules\contribute\models\traits\ActiveRecordTrait;

class Taxonomy extends \app\models\Taxonomy
{
    use ActiveRecordTrait;

    public static function getAllNamesAsArray(): array
    {
        $names = self::find()
            ->select(['id', 'name', 'uniprot_id'])
            ->asArray()
            ->all();
        $result = [];
        foreach ($names as $name) {
            $result[$name['id']] = "{$name['name']} (ID {$name['uniprot_id']})";
        }
        return $result;
    }
    
    
}

