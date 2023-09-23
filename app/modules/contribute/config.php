<?php
return [
    
    'params' => [ ],
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => getenv('SMTP_USER'),
                'password' => getenv('SMTP_PASS'),
                'port' => '587',
                'encryption' => 'tls',
            ],
            'htmlLayout' => '@app/modules/contribute/views/mail/layouts/html',
            'textLayout' => '@app/modules/contribute/views/mail/layouts/text'
        ],
    ],
];