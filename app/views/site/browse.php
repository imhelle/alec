<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\JsExpression;
use yii\widgets\Pjax;
use dosamigos\chartjs\ChartJs;


/* @var $this yii\web\View */
/* @var $searchModel app\models\ExperimentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Browse ITP data';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="experiment-index">

    <h2><?= Html::encode($this->title) ?></h2>
    
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]);
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

//            'id',
            'umn',
            [
                'label' => 'Site',
                'attribute' => 'site',
                'filter' => array("TJL" => "The Jackson Laboratory", "UM" => "University of Michigan at Ann Arbor", "UT" => "University of Texas Health Science Center"),
                'value' => function ($model) {
                    /** \app\models\Experiment $model */
                    switch ($model->site) {
                        case "TJL": return "The Jackson Laboratory";
                        case "UM": return "University of Michigan at Ann Arbor";
                        case "UT": return "University of Texas Health Science Center";
                    }
                    return '';
                },
            ],
            [
                'label' => 'Sex',
                'attribute' => 'sex',
                'filter' => array(0=>"female",1=>"male"),
                'value' => function ($model) {
                    /** \app\models\Experiment $model */
                    return $model->sex == 1 ? 'male' : 'female';
                },
            ],
            'status',
            'age',
            //'dead',
            'year',
            'group',
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
