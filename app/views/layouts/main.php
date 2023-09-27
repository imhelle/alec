<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\assets\CmsAsset;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\widgets\Breadcrumbs;

CmsAsset::register($this);
$css = getenv('BASE_URL') ? '/' . getenv('BASE_URL') . '/assets/css/main.css' : '/assets/css/main.css';
$this->registerCssFile($css);
$title = $this->title ?? 'ALEC mice - Animal Life Expectancy Comparisons in Mice';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html style="font-size: 14px" lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($title) ?></title>
    <?php $this->head() ?>
</head>
<body class="alec">
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => $title, 
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top alec-navbar',
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container content">
<!--        --><?php //= Breadcrumbs::widget([
//            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
//        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?> 
            <br>Developed by Olga Spiridonova under supervision of <a href="https://scholar.google.com/citations?user=WMhS0lAAAAAJ" target="_blank">Leon Peshkin</a>
            <br>Supported by a Longevity Impetus Grant from Norn Group to Olga Spiridonova
            <br>
            Data courtesy of <a href="https://www.nia.nih.gov/research/dab/interventions-testing-program-itp" target="_blank">ITP</a>
        </p>
        <p class="pull-right"></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
