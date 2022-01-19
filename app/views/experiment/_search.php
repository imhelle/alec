<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ExperimentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="experiment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'umn') ?>

    <?= $form->field($model, 'site') ?>

    <?= $form->field($model, 'sex') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'age') ?>

    <?php // echo $form->field($model, 'dead') ?>

    <?php // echo $form->field($model, 'year') ?>

    <?php // echo $form->field($model, 'group') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
