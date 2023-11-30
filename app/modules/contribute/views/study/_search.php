<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\contribute\models\StudySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="study-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'journal') ?>

    <?= $form->field($model, 'doi') ?>

    <?= $form->field($model, 'pubmed_id') ?>

    <?= $form->field($model, 'full_text_URL') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'authors') ?>

    <?php // echo $form->field($model, 'year') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
