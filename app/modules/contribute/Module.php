<?php

namespace app\modules\contribute;

/**
 * contribute module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\contribute\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {

//        \Yii::configure($this, require __DIR__ . '/config.php');
        
        parent::init();

        \Yii::$app->setComponents([

            'mailer' => [
                'class' => 'yii\swiftmailer\Mailer',
                'transport' => [
                    'class' => 'Swift_SmtpTransport',
                    'host' => getenv('SMTP_SERVER'),
                    'username' => getenv('SMTP_USER'),
                    'password' => getenv('SMTP_PASS'),
                    'port' => '2525',
                    'encryption' => 'tls',
                ],
                'htmlLayout' => '@app/modules/contribute/views/mail/layouts/html',
                'textLayout' => '@app/modules/contribute/views/mail/layouts/text'
            ],

        ]);

        // custom initialization code goes here
    }
}
