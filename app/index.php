<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/config/bootstrap.php';

$dotenv = Dotenv\Dotenv::create(Yii::getAlias('@app'));
$dotenv->load();

defined('YII_DEBUG') or define('YII_DEBUG', getenv('DEBUG'));
defined('YII_ENV') or define('YII_ENV', getenv('ENV'));


$config = require __DIR__ . '/config/main.php';

(new yii\web\Application($config))->run();
