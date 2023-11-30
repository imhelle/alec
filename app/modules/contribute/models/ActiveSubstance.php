<?php

namespace app\modules\contribute\models;

use app\modules\contribute\models\traits\ActiveRecordTrait;

class ActiveSubstance extends \app\models\ActiveSubstance
{
    use ActiveRecordTrait;

    public static function getAllNamesAsArray(): array
    {
        $names = self::find()
            ->select(['id', 'name', 'pubchem_id'])
            ->asArray()
            ->all();
        $result = [];
        foreach ($names as $name) {
            $fullName = $name['pubchem_id'] ? "{$name['name']} (ID {$name['pubchem_id']})" : "{$name['name']}";
            $result[$name['id']] = $fullName;
        }
        return $result;
    }
}

