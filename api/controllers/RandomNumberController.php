<?php
namespace api\controllers;

use common\models\RandomNumber;
use common\models\User;
use Yii;
use yii\base\InvalidParamException;
use yii\rest\Controller as RestController;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\filters\ContentNegotiator;
use yii\web\Response;

class RandomNumberController extends RestController
{
	public function behaviors()
	{
		$behaviors = parent::behaviors();

		$behaviors['contentNegotiator'] = [
			'class' => ContentNegotiator::className(),
			'except' => ['index'],
			'formats' => [
				'text/html' => Response::FORMAT_JSON,
				'application/json' => Response::FORMAT_JSON,
				'application/xml' => Response::FORMAT_XML,
			],
		];

		return $behaviors;
	}

	public function actionIndex()
	{
		return <<<HTML
Available methods:<br/>
<table border="1">
<thead><tr><th>Method</th><th>Desc</th></tr></thead>
<tbody>
<tr>
<td><strong>generate</strong></td>
<td>Return ID of new random digit<br/>
<i>if you send 'max' in request body, will return random number from 0 to 'max';<br/>
if you send 'min' and 'max', will return number from 'min' to 'max', on condition 'max' > 'min'</i>
</td>
</tr>
<tr>
<td><strong>retrieve</strong></td>
<td>Return random digit by ID<br/>
<i>you can to send ID with GET in query string or in JSON/XML body with POST and relevant mime-type in HTTP header 'Content-Type';<br/>
for returning response in JSON/XML send relevant mime-type in HTTP header 'Accept'</i>
</td>
</tr>
</tbody>
</table>
HTML;
	}

	public function actionGenerate()
	{
		$requestBody = Yii::$app->request->getBodyParams();

		$model = new RandomNumber();
		$model->generate($requestBody);

		if ($model->save() === false && !$model->hasErrors()) {
			throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
		}

		return $model;
	}

	public function actionRetrieveGet($number_id)
	{
		if (!is_numeric($number_id)) {
			throw new InvalidParamException('Please send correct numeric parameter of ID.');
		}

		$model = RandomNumber::findOne($number_id);
		if (!$model) {
			return [
				'error' => 'Number with this ID is not exist',
				'code' => 404,
			];
		}
		return [
			'number' => $model->number,
			'_links' => [
				'self' => [
					'href' => $model->getLinkSelf()
				]
			]
		];
	}

	public function actionRetrievePost()
	{
		$requestBody = Yii::$app->request->getBodyParams();

		if (!isset($requestBody['number_id'])) {
			throw new NotFoundHttpException('Please send correct numeric parameter of ID.');
		}

		$model = RandomNumber::findOne($requestBody['number_id']);
		if (!$model) {
			return [
				'error' => 'Number with this ID is not exist',
				'code' => 404,
			];
		}
		return [
			'number' => $model->number,
			'_links' => [
				'self' => [
					'href' => $model->getLinkSelf()
				]
			]
		];
	}


	public function verbs()
	{
		return [
			'index' => ['get'],
			'generate' => ['get', 'post'],
			'retrieve-get' => ['get'],
			'retrieve-post' => ['post'],
		];
	}
}