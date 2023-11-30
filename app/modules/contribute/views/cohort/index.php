<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\contribute\models\CohortSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cohorts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cohort-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Cohort', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'study_id',
            'temperature',
//            'dwelling_id',
//            'animals_per_dwelling',
            'control',
//            'cohort_size',
//            'taxonomy_id',
            [
                'label' => 'Taxonomy',
                'value' => function ($model) {
                    /* @var $model \app\models\Study  */
                    return $model->getCohortsCount();
                },
//                'filter' => Html::activeDropDownList($cohortSearchModel, 'active_substance_id',
//                    [0 => ' - Control - '] + \app\models\ActiveSubstance::getList(), ['prompt' => ' - Any - ' . PHP_EOL, 'class' => 'form-control']),

//                'headerOptions' => ['style' => 'min-width:100px; text-align: center'],
//                'contentOptions' => ['style' => 'vertical-align: middle; text-align: center'],
            ],
//            'strain_id',
            'site',
            'sex',
            'age_of_start',
//            'smoothed_lifespan_last_decile_age',
//            'smoothed_lifespan_median_age',
            'light_conditions',
            'diet_description:ntext',
            'type_of_experiment',
            'active_substance_id',
            'dosage',
            'vehicle',
            'diet_intervention_description:ntext',
            //'temperature_unit',
            //'age_unit',
            //'remarks:ntext',
            //'health_parameters:ntext',
            //'year',
            //'timestamp',
            //'enabled',
            //'comment',
            //'source',
            //'collida_id',
            //'user_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
