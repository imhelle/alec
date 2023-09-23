<?php
$notifyEmailsString = getenv('NOTIFY_EMAILS');
$notifyEmails = $notifyEmailsString ? explode(',', $notifyEmailsString) : [];
return [
    'adminEmail' => 'alec@lifespan-explorer.org',
    'notifyEmails' => array_merge(['sp.olga.inf@gmail.com'], $notifyEmails),
    'supportEmail' => 'alec@lifespan-explorer.org',
    'senderEmail' => 'alec@lifespan-explorer.org',
    'senderName' => 'ALEC',
    'user.passwordResetTokenExpire' => 3600,
    'bsVersion' => 5,

    'servicesPath' => [

    ]
];
