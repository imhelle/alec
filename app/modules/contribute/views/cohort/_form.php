<?php

use app\modules\contribute\models\DwellingType;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\contribute\models\Cohort */
/* @var $form yii\widgets\ActiveForm */
$lifespans = $model->getLifespansArray();
var_dump($lifespans);
?>

<?php $form = ActiveForm::begin(); ?>
<div class="cohort-form">
    <?= $model->study->doi ?> <?= $model->study->pubmed_id ?>
    <div class="row">
        <div class="col-12">
            Lifespans: <?= count($lifespans); ?>, max: <?= max($lifespans); ?>
        </div>
        <div class="col-11">
            <div class="row" style="margin-top: 50px"><!--<div class="row justify-content-center">-->
                <h4>Conditions</h4>
                <div class="col-2">
                    <label>Dwelling</label>
                    <?= \kartik\select2\Select2::widget([
                        'model' => $model,
                        'attribute' => 'dwelling_id',
                        'data' => DwellingType::getAllNamesAsArray(),
                        'options' => [
                            'placeholder' => 'dwelling',
                            'multiple' => false
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-1">
                    <?= $form->field($model, 'animals_per_dwelling')->textInput()->label('Animals p/dw.') ?>
                </div>
                <div class="col-2">
                    <?= $form->field($model, 'temperature')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-2">
                    <?= $form->field($model, 'temperature_unit')->textInput(['maxlength' => true])->label('Temp.unit') ?>
                </div>
                <div class="col-2">
                    <?= $form->field($model, 'light_conditions')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row" style="margin-top: 20px">
                <?= $form->field($model, 'diet_description')->textInput() ?>
            </div>
            <div class="row" style="margin-top: 50px"><!--<div class="row justify-content-center">-->
                <h4>Animals</h4>
                <div class="col-3">
                    <label>Taxonomy</label>
                    <?= \kartik\select2\Select2::widget([
                        'model' => $model,
                        'attribute' => 'taxonomy_id',
                        'data' => \app\modules\contribute\models\Taxonomy::getAllNamesAsArray(),
                        'options' => [
                            'placeholder' => 'taxonomy',
                            'multiple' => false
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-2">
                    <label>Strain</label>
                    <?= \kartik\select2\Select2::widget([
                        'model' => $model,
                        'attribute' => 'strain_id',
                        'data' => \app\modules\contribute\models\Strain::getAllNamesAsArray(),
                        'options' => [
                            'placeholder' => 'strain',
                            'multiple' => false
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-2">
                    <?= $form->field($model, 'sex')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-2">
                    <?= $form->field($model, 'cohort_size')->textInput() ?>
                </div>
                <div class="col-2">
                    <?= $form->field($model, 'year')->textInput()->label('Cohort birth year') ?>
                </div>

            </div>
            <div class="row" style="margin-top: 50px"><!--<div class="row justify-content-center">-->
                <h4>Experiment</h4>
                <div class="col-1">
                    <!--            <label>Control group</label>-->

                </div>
                <div class="form-check form-switch">
                    <!--            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">-->
                    <?= $form->field($model, 'control')->checkbox()->label('') ?>
                    <label class="form-check-label" for="flexSwitchCheckDefault">Default switch checkbox input</label>
                </div>
                <div class="col-3">
                    <label>Active Substance</label>
                    <?= \kartik\select2\Select2::widget([
                        'model' => $model,
                        'attribute' => 'active_substance_id',
                        'data' => \app\modules\contribute\models\ActiveSubstance::getAllNamesAsArray(),
                        'options' => [
                            'placeholder' => 'Active Substance',
                            'multiple' => false
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                    ?>
                </div>

                <div class="col-2">
                    <?= $form->field($model, 'type_of_experiment')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-1">
                    <?= $form->field($model, 'dosage')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-2">
                    <?= $form->field($model, 'vehicle')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-1">
                    <?= $form->field($model, 'age_of_start')->textInput() ?>
                </div>
                <div class="col-1">
                    <?= $form->field($model, 'age_unit')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-1">
                    <?= $form->field($model, 'site')->textInput(['maxlength' => true]) ?>
                </div>

                <?= $form->field($model, 'diet_intervention_description')->textarea(['rows' => 6]) ?>
            </div>
            <div class="row" style="margin-top: 50px"><!--<div class="row justify-content-center">-->
                <div class="col-3">
                    <?= $form->field($model, 'smoothed_lifespan_last_decile_age')->textInput() ?>
                </div>
                <div class="col-3">
                    <?= $form->field($model, 'smoothed_lifespan_median_age')->textInput() ?>
                </div>
            </div>




            <?= $form->field($model, 'remarks')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'health_parameters')->textarea(['rows' => 6, 'height' => '100%']) ?>
            
        </div>
        <div class="col-1">
            <?= $form->field($model, 'plainLifespans')->textarea(['rows' => 1]) ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
