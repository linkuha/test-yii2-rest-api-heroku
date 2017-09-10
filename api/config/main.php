<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'application/xml' => 'yii\web\XmlParser',
            ],
        ],
        'response' => [
			//'format' => 'json', // по умолчанию
            'formatters' => [
				'json' => [
					'class' => 'yii\web\JsonResponseFormatter',
					'prettyPrint' => YII_DEBUG,
					'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
				],
				'xml' => [
					'class' => 'yii\web\XmlResponseFormatter',
				],
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'random-number/index',
                //'auth' => 'site/login',

				'generate' => 'random-number/generate',
				'GET retrieve/<number_id:\d+>' => 'random-number/retrieve-get',
				'POST retrieve' => 'random-number/retrieve-post',


                //'GET profile' => 'profile/index',
                //'PUT,PATCH profile' => 'profile/update',

				// само перестроит пути множ.числа, например в posts/123
                //['class' => 'yii\rest\UrlRule', 'controller' => 'post'],
            ],
        ],
    ],
    'params' => $params,
];
