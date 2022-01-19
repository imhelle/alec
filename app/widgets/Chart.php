<?php

namespace app\widgets;

use Yii;


class Chart extends \yii\bootstrap\Widget
{
    public $allControlsCoordinates = [];
    public $allDrugCoordinates = [];

    function run()
    {
        return $this->render('chart', [
            'allControlsCoordinates' => $this->allControlsCoordinates,
            'allDrugCoordinates' => $this->allDrugCoordinates,
        ]);
    }
}
