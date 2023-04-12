<?php

use app\models\ExperimentOld;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\JsExpression;
use yii\widgets\Pjax;
use dosamigos\chartjs\ChartJs;


/* @var $this yii\web\View */
/* @var $allControlsCoordinates */
/* @var $allDrugCoordinates */
/* @var $aspirinCoordinates */
/* @var $rapaCoordinates */
/* @var $median */
/* @var $total */
///* @var $searchModel app\models\ExperimentSearch */
///* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $cohortSearchModel app\models\Cohort */
/* @var $cohortDataProvider yii\data\ActiveDataProvider */

$this->title = 'Animal Life Expectancy Comparisons';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs(
    <<< JS
function onLegendClicked(e, i) {
  const hidden = !chart.data.datasets[i].hidden;
  chart.data.datasets[i].hidden = hidden;
  const legendLabelSpan = document.getElementById("legend-label-" + i);
  legendLabelSpan.style.textDecoration = hidden ? 'line-through' : '';
  chart.update();
};
JS
    , \yii\web\View::POS_HEAD
);

?>
    <div class="experiment-index">
        <?php $form = \yii\bootstrap\ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'id' => 'uploadForm']]) ?>
        <label class="custom-file-upload btn btn-blue">
            <?= Html::fileInput('upload', null, ['style' => 'display: none', 'id' => 'upload_field']) ?>
            <span id="file-selected">Upload CSV file</span>
        </label>
        <?php \yii\bootstrap\ActiveForm::end(); ?>
        <?php 
            echo \app\widgets\Chart::widget([
                'allControlsCoordinates' => $allControlsCoordinates,
                'allDrugCoordinates' => $allDrugCoordinates,
            ])
        ?>
        <br>
        <div id="js-legend" class="chart-legend"></div>
        <div class="limits">Range limit <?= Html::input('input', 'start', '0', ['id' => 'chart_start', 'class' => 'form-control']) ?> to
            <?= Html::input('input', 'end', '', ['id' => 'chart_end', 'class' => 'form-control']) ?><button type='button' class='btn' style='margin-left: 10px;'>Ok</button>
        </div>

        <?php Pjax::begin(); ?>

<!--        --><?php //GridView::widget([
//            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
//            'summary' => "{totalCount} records selected (out of {$total} total), {$median} median lifespan - 
//                <button type='button'  id='add_data' class='btn btn-blue'>Plot</button>
//                <button type='button'  id='download' class='btn btn-blue'>Download CSV</button>",
//            'layout' => "<div style='float: left'>{summary}<a href ='/'><button type='reset' class='btn' style='margin-left: 10px; color: #000'>Reset Filters</button></a>
//                <button type='button' id='clear_data' class='btn' style='margin-left: 10px;'>Clear Charts</button></div>\n{items}",
//            'columns' => [
//
////            'id',
////            'umn',
//                [
//                    'label' => 'Strain',
//                    'attribute' => 'strain',
////                    'filter' => \kartik\select2\Select2::widget([
////                        'name' => 'ExperimentSearch[selectedStrains]',
////                        'value' => $searchModel->selectedStrains,
////                        'data' => ['Any' => 'Any'] + Experiment::getStrains(),
////                        'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
////                        'options' => [
////                                'multiple' => true,
////                            'value' => $searchModel->selectedStrains,
////                            'placeholder' => 'Any'
////                        ],
////                        'pluginOptions' => [
////                            'allowClear' => true,
////                            'placeholder' => 'Any',
////                            'debug' => true
////                        ],
////                    ]),
//                    'filter' => Html::activeDropDownList($searchModel, 'strain',
//                        ExperimentOld::getStrains(), ['prompt' => 'Any' . PHP_EOL, 'class' => 'form-control']), 
//                    'headerOptions' => ['style' => 'min-width:100px'],
//                ],
//                [
//                    'label' => 'Sex',
//                    'attribute' => 'sex',
//                    'filter' => Html::activeDropDownList($searchModel, 'sex',
//                        [0 => "Female", 1 => "Male"], ['prompt' => 'Any' . PHP_EOL, 'class' => 'form-control']),
//                    'value' => function ($model) {
//                        /** \app\models\Experiment $model */
//                        return $model->sex == 1 ? 'Male' : 'Female';
//                    },
//                    'headerOptions' => ['style' => 'min-width:100px'],
//                ],
//                [
//                    'label' => 'Intervention',
//                    'attribute' => 'drug_name',
//                    'filter' => Html::activeDropDownList($searchModel, 'drug_name',
//                        ExperimentOld::getDrugs(), ['prompt' => 'Any' . PHP_EOL, 'class' => 'form-control']),
//                    'headerOptions' => ['style' => 'min-width:150px'],
//                ],
//                [
//                    'attribute' => 'age',
//                    'headerOptions' => ['style' => 'width:100px'],
//                ],
//                [
//                    'attribute' => 'year',
//                    'headerOptions' => ['style' => 'width:100px'],
//                ],
//                [
//                    'label' => 'Site',
//                    'attribute' => 'site',
//                    'filter' => Html::activeDropDownList($searchModel, 'site',
//                        ["TJL" => "The Jackson Laboratory", "UM" => "University of Michigan at Ann Arbor", "UT" => "University of Texas Health Science Center"],
//                        ['prompt' => 'Any' . PHP_EOL, 'class' => 'form-control']),
//                    'value' => function ($model) {
//                        /** \app\models\Experiment $model */
//                        switch ($model->site) {
//                            case "TJL":
//                                return "The Jackson Laboratory";
//                            case "UM":
//                                return "University of Michigan at Ann Arbor";
//                            case "UT":
//                                return "University of Texas Health Science Center";
//                        }
//                        return '';
//                    },
//                    'headerOptions' => ['style' => 'min-width:250px'],
//                ],
//                [
//                    'attribute' => 'source',
//                    'filter' => Html::activeDropDownList($searchModel, 'source',
//                        ExperimentOld::getSources(),
//                        ['prompt' => 'Any' . PHP_EOL, 'class' => 'form-control']),
//                    'headerOptions' => ['style' => 'min-width:250px'],
//                ],
//            ],
//        ]); ?>

        <?= GridView::widget([
            'dataProvider' => $cohortDataProvider,
            'filterModel' => $cohortSearchModel,
            'summary' => "{totalCount} records selected (out of {$total} total), {$median} median lifespan - 
                <button type='button'  id='add_data' class='btn btn-blue'>Plot</button>
                <button type='button'  id='download' class='btn btn-blue'>Download CSV</button>",
            'layout' => "<div style='float: left'>{summary}<a href ='/'><button type='reset' class='btn' style='margin-left: 10px; color: #000'>Reset Filters</button></a>
                <button type='button' id='clear_data' class='btn' style='margin-left: 10px;'>Clear Charts</button></div>\n{items}",
            'columns' => [

//            'id',
//            'umn',
                [
                    'label' => 'Strain',
                    'attribute' => 'strain.name',
//                    'filter' => \kartik\select2\Select2::widget([
//                        'name' => 'ExperimentSearch[selectedStrains]',
//                        'value' => $searchModel->selectedStrains,
//                        'data' => ['Any' => 'Any'] + Experiment::getStrains(),
//                        'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
//                        'options' => [
//                                'multiple' => true,
//                            'value' => $searchModel->selectedStrains,
//                            'placeholder' => 'Any'
//                        ],
//                        'pluginOptions' => [
//                            'allowClear' => true,
//                            'placeholder' => 'Any',
//                            'debug' => true
//                        ],
//                    ]),
                    'filter' => Html::activeDropDownList($cohortSearchModel, 'strain_id',
                        \app\models\Strain::getList(), ['prompt' => 'Any' . PHP_EOL, 'class' => 'form-control']),
                    'headerOptions' => ['style' => 'min-width:100px'],
                ],
                [
                    'label' => 'Sex',
                    'attribute' => 'sex',
                    'filter' => Html::activeDropDownList($cohortSearchModel, 'sex',
                        ['female' => "female", 'male' => "male"], ['prompt' => 'Any' . PHP_EOL, 'class' => 'form-control']),
                    'headerOptions' => ['style' => 'min-width:100px'],
                ],
//                [
//                    'attribute' => 'age',
//                    'headerOptions' => ['style' => 'width:100px'], // todo max, med
//                ],
                [
                    'label' => 'Active substance',
                    'attribute' => 'activeSubstance.name',
                    'filter' => Html::activeDropDownList($cohortSearchModel, 'active_substance_id',
                        \app\models\ActiveSubstance::getList(), ['prompt' => 'Any' . PHP_EOL, 'class' => 'form-control']),
                    'headerOptions' => ['style' => 'min-width:100px'],
                ],
                'dosage',
                [
                    'label' => 'Start age',
                    'attribute' => 'age_of_start',
                    'value' => function ($model) {
                        /** @var \app\models\Cohort $model */
                        return $model->age_of_start . ' ' . $model->age_unit;
                    },
                    'headerOptions' => ['style' => 'width:100px'],
                ],
                [
                    'label' => 'Study',
                    'value' => function ($model) {
                        /** @var \app\models\Cohort $model */
                        return "<a href='https://doi.org/{$model->study->doi}' target='_blank'>PMID&nbsp;{$model->study->pubmed_id}</a> {$model->study->year}";
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'Lifespan',
                    'value' => function ($model) {
                        /** @var \app\models\Cohort $model */
                        return "{$model->getMedLifespan()} {$model->getMaxLifespan()}";
                    },
                    'format' => 'html',
                ],
                [
                    'label' => 'Cohort year',
                    'attribute' => 'year',
                ],
                'remarks',
                [
                    'label' => 'Site',
                    'attribute' => 'site',
                    'filter' => Html::activeDropDownList($cohortSearchModel, 'site',
                        ["TJL" => "The Jackson Laboratory", "UM" => "University of Michigan at Ann Arbor", "UT" => "University of Texas Health Science Center"],
                        ['prompt' => 'Any' . PHP_EOL, 'class' => 'form-control']),
                    'value' => function ($model) {
                        /** \app\models\Experiment $model */
                        switch ($model->site) {
                            case "TJL":
                                return "The Jackson Laboratory";
                            case "UM":
                                return "University of Michigan at Ann Arbor";
                            case "UT":
                                return "University of Texas Health Science Center";
                        }
                        return '';
                    },
                    'headerOptions' => ['style' => 'min-width:250px'],
                ],
            ],
        ]); ?>

        <?php Pjax::end(); ?>
        <br>
        Lifespan: what is surprising?
        <br>This project is aimed at providing the answers to questions like:<br>
        <ul>
            <li>What are the longest and shortest living strains of mice?</li>
            <li>How does temperature affect the lifespan of worms?</li>
            <li>Which strain of rats lives the same long on different diets?</li>
            <li>Has there been any change in the lifespan of the same fly species with the same keeping conditions over
                time?
            </li>
            <li>Which husbandry conditions produce the longest lifespan in certain species?</li>
        </ul>
        <br>
        References:
        <br>
        [1] <a href="https://www.nia.nih.gov/research/dab/interventions-testing-program-itp" target="_blank">ITP:
            Intervention Testing in Mice</a><br>
        [2]
        <a href="https://www.google.com/url?q=https%3A%2F%2Fcitp.squarespace.com&sa=D&sntz=1&usg=AFQjCNGXkFOR-c9ziy0yCncbr03ESxoIuQ"
           target="_blank">ITP in worms</a><br>
        [3]
        <a href="http://www.google.com/url?q=http%3A%2F%2Fgenomics.senescence.info%2Fdrugs&sa=D&sntz=1&usg=AFQjCNElTK1Rxv7bGdZ5WMYAVc5HonmXsg"
           target="_blank">DrugAge</a><br>
        [4] Lucanic M, et al. Pharmacological lifespan extension of invertebrates. doi: 10.1016/j.arr.2012.06.006.<br>
        <br>

    </div>

<?php
