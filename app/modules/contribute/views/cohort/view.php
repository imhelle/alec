<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Cohort */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cohorts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cohort-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'study_id',
            'temperature',
            'dwelling_id',
            'animals_per_dwelling',
            'control',
            'cohort_size',
            'taxonomy_id',
            'strain_id',
            'site',
            'sex',
            'age_of_start',
            'smoothed_lifespan_last_decile_age',
            'smoothed_lifespan_median_age',
            'light_conditions',
            'diet_description:ntext',
            'type_of_experiment',
            'active_substance_id',
            'dosage',
            'vehicle',
            'diet_intervention_description:ntext',
            'temperature_unit',
            'age_unit',
            'remarks:ntext',
            'health_parameters:ntext',
            'year',
            'timestamp',
            'enabled',
            'comment',
            'source',
            'collida_id',
            'user_id',
        ],
    ]) ?>

</div>
