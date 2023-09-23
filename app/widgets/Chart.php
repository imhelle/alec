<?php

namespace app\widgets;

use Yii;


class Chart extends \yii\bootstrap5\Widget
{
    public $allControlsCoordinates = [];
    public $allDrugCoordinates = [];
    public $charts = [];

    function run()
    {
        $datasets = [[
            'label' => 'special_median_line',
            'backgroundColor' => "rgba(198, 93, 87, 0)",
            'borderColor' => "rgba(198, 198, 198, 1)",
            'pointBackgroundColor' => "rgba(198, 198, 198, 1)",
            'pointBorderWidth' => 0,
            'pointRadius' => 1,
            'pointHoverRadius' => 4,
            'pointHoverBackgroundColor' => "#fff",
            'pointHoverBorderColor' => "rgba(198, 198, 198, 1)",
            'data' => [['x' => 0, 'y' => 50], ['x' => 1600, 'y' => 50]],
            'borderDash' => [5, 5],
            'borderWidth' => 1,
            'steppedLine' => true,
        ],
        ];
        if ($this->charts) {
            foreach ($this->charts as $chart) {
                $datasets[] = $chart;
            }
        } else {
            $datasets = array_merge($datasets, [
                [
                    'label' => "All Controls",
                    'backgroundColor' => "rgba(125, 201, 209, 0)",
                    'borderColor' => "rgba(125, 201, 209, 1)",
                    'pointBackgroundColor' => "rgba(125, 201, 209, 1)",
                    'pointBorderWidth' => 0,
                    'pointRadius' => 1,
                    'pointHoverRadius' => 4,
                    'pointHoverBackgroundColor' => "#fff",
                    'pointHoverBorderColor' => "rgba(125, 201, 209, 1)",
                    'data' => $this->allControlsCoordinates,
                    'steppedLine' => true,
                ]
            ]);
        }

        return $this->render('chart', ['datasets' => $datasets]);
    }
}
