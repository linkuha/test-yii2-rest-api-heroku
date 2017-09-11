<?php
$host = $username = $password = $dbname = '';
$url = parse_url(getenv('DATABASE_URL'));

if (isset($url["host"]) && isset($url["user"]) && isset($url["pass"]) && isset($url["path"])) {
	$host = $url["host"];
	$username = $url["user"];
	$password = $url["pass"];
	$dbname = ltrim($url["path"],'/'); //substr($url["path"], 1);
	$port = $url["port"];
}

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => "pgsql:host=$host;port=$port;dbname=$dbname",	//not mysql:
            'username' => $username, //'random_usr',
            'password' => $password, //'3e2w1qqwe',
            //'charset' => 'utf8',
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
