<?php
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
        ],
    ],
];
