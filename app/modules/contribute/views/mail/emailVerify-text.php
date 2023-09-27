<?php

/** @var yii\web\View $this */
/** @var \app\modules\contribute\models\User $user */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['contribute/auth/verify-email', 'token' => $user->verification_token]);
?>
Hello <?= $user->username ?>,

Follow the link below to verify your email:

<?= $verifyLink ?>
