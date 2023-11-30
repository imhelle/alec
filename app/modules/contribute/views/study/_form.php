<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Study */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="study-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'journal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'doi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pubmed_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'full_text_URL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'authors')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'year')->textInput() ?>

    <?= $form->field($model, 'remarks')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'timestamp')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
