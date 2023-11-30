<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\contribute\models\CohortSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cohort-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'study_id') ?>

    <?= $form->field($model, 'temperature') ?>

    <?= $form->field($model, 'dwelling_id') ?>

    <?= $form->field($model, 'animals_per_dwelling') ?>

    <?php // echo $form->field($model, 'control') ?>

    <?php // echo $form->field($model, 'cohort_size') ?>

    <?php // echo $form->field($model, 'taxonomy_id') ?>

    <?php // echo $form->field($model, 'strain_id') ?>

    <?php // echo $form->field($model, 'site') ?>

    <?php // echo $form->field($model, 'sex') ?>

    <?php // echo $form->field($model, 'age_of_start') ?>

    <?php // echo $form->field($model, 'smoothed_lifespan_last_decile_age') ?>

    <?php // echo $form->field($model, 'smoothed_lifespan_median_age') ?>

    <?php // echo $form->field($model, 'light_conditions') ?>

    <?php // echo $form->field($model, 'diet_description') ?>

    <?php // echo $form->field($model, 'type_of_experiment') ?>

    <?php // echo $form->field($model, 'active_substance_id') ?>

    <?php // echo $form->field($model, 'dosage') ?>

    <?php // echo $form->field($model, 'vehicle') ?>

    <?php // echo $form->field($model, 'diet_intervention_description') ?>

    <?php // echo $form->field($model, 'temperature_unit') ?>

    <?php // echo $form->field($model, 'age_unit') ?>

    <?php // echo $form->field($model, 'remarks') ?>

    <?php // echo $form->field($model, 'health_parameters') ?>

    <?php // echo $form->field($model, 'year') ?>

    <?php // echo $form->field($model, 'timestamp') ?>

    <?php // echo $form->field($model, 'enabled') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'source') ?>

    <?php // echo $form->field($model, 'collida_id') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
