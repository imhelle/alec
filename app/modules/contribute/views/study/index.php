<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\contribute\models\StudySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\widgets\Pjax;

$this->title = 'Studies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="study-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Study', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'doi',
            'pubmed_id',
            'full_text_URL:url',
            //'email:email',
            'authors:ntext',
            'year',
            //'remarks:ntext',
            //'timestamp',
            [
                'label' => 'Cohorts count',
                'value' => function ($model) {
        /* @var $model \app\models\Study  */
                    return $model->getCohortsCount();
                },
//                'filter' => Html::activeDropDownList($cohortSearchModel, 'active_substance_id',
//                    [0 => ' - Control - '] + \app\models\ActiveSubstance::getList(), ['prompt' => ' - Any - ' . PHP_EOL, 'class' => 'form-control']),

//                'headerOptions' => ['style' => 'min-width:100px; text-align: center'],
//                'contentOptions' => ['style' => 'vertical-align: middle; text-align: center'],
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

</div>
