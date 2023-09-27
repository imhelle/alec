<?php

namespace app\modules\contribute\controllers;

use app\modules\contribute\models\ResendVerificationEmailForm;
use app\modules\contribute\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\modules\contribute\models\LoginForm;
use app\modules\contribute\models\PasswordResetRequestForm;
use app\modules\contribute\models\ResetPasswordForm;
use app\modules\contribute\models\SignupForm;
use app\modules\contribute\models\ContactForm;

/**
 * Default controller for the `contribute` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

   
    
}
