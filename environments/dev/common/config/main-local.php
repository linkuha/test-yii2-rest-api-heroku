<?php
$dbopts = parse_url(getenv('DATABASE_URL'));
$dbname = ltrim($dbopts["path"],'/');
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => "pgsql:host={$dbopts['host']};port={$dbopts['port']};dbname=$dbname",	//not mysql:
            'username' => $dbopts["user"], //'random_usr',
            'password' => $dbopts["pass"], //'3e2w1qqwe',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
