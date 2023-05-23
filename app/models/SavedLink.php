<?php

namespace app\models;

use InvalidArgumentException;
use yii\helpers\ArrayHelper;

class SavedLink extends ar\SavedLink
{
    public static function saveLink($postArray)
    {
        $model = new self();
        $model->url = $postArray['url'];
        $model->chart = $postArray['charts'];
        $model->timestamp = (string)time();
        $model->link = uniqid();
        if (!$model->save()) {
            return json_encode(['error' => $model->getErrorSummary(true)]);
        }
        return json_encode(['link' => $model->link]);
    }

}

