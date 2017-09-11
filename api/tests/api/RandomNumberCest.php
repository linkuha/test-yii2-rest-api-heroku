<?php

namespace api\tests\api;

use \api\tests\ApiTester;
use common\fixtures\RandomNumberFixture;
use common\models\RandomNumber;

class RandomNumberCest
{
	public function _before(ApiTester $I)
	{
		$I->haveFixtures([
			'random-number' => [
				'class' => RandomNumberFixture::className(),
				'dataFile' => codecept_data_dir() . 'random-number.php'
			],
		]);
	}

	public function indexHtml(ApiTester $I)
	{
		$I->sendGET('/');
		$I->seeResponseCodeIs(200);
		$I->seeHttpHeader('Content-Type');
		$contentType = $I->grabHttpHeader('Content-Type');
		$I->assertTrue(strpos($contentType, 'text/html') !== false);
	}

	public function generateGetPure(ApiTester $I)
	{
		$I->sendGET('/generate');
		$I->seeResponseCodeIs(200);
		$I->seeResponseIsJson();
		$I->seeResponseJsonMatchesXpath('//number');
	}

	public function generateGetToXml(ApiTester $I)
	{
		$I->haveHttpHeader('Accept', 'application/xml');
		$I->sendGET('/generate');
		$I->seeResponseCodeIs(200);
		$I->seeResponseIsXml();
		$I->seeResponseContains(
			'<number>'
		);
	}

	public function generatePostBorders(ApiTester $I)
	{
		$I->haveHttpHeader('Accept', 'application/json');
		$I->sendPOST('/generate', [
			'max' => 20,
			'min' => 5
		]);
		$I->seeResponseCodeIs(200);
		$I->seeResponseIsJson();
		$number = $I->grabDataFromResponseByJsonPath('$..number');
		$I->assertLessThanOrEqual(20, (int) $number[0]);
		$I->assertLessThanOrEqual((int) $number[0], 5);
	}

	public function generatePostToXml(ApiTester $I)
	{
		$I->haveHttpHeader('Accept', 'application/xml');
		$I->sendPOST('/generate');
		$I->seeResponseIsXml();
		$I->seeResponseContains(
			'<number>'
		);
	}

	public function retrieveGet(ApiTester $I)
	{
		$I->haveHttpHeader('Accept', 'application/json');
		$I->sendGET('/retrieve/102');
		$I->seeResponseCodeIs(200);
		$I->seeResponseIsJson();
		$I->seeResponseContainsJson([
			'number' => 14,
		]);
		$I->dontSeeResponseContainsJson([
			'id' => 102,
			'created_at' => date(DATE_RFC3339, 1392559495),
		]);
	}

	public function retrieveWrong(ApiTester $I)
	{
		$I->haveHttpHeader('Accept', 'application/json');
		$I->sendGET('/retrieve/100');
		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson([
			'code' => 404,
		]);
	}

	public function retrieveGetExtra(ApiTester $I)
	{
		$I->haveHttpHeader('Accept', 'application/json');
		$I->sendGET('/retrieve/102?expand=id,created_at');
		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson([
			'number' => 14,
		]);
		$I->seeResponseContainsJson([
			'id' => 102,
			'created_at' => date(DATE_RFC3339, 1392559495)
		]);
	}

	// test application/x-www-form-urlencoded
	public function retrievePost(ApiTester $I)
	{
		$I->haveHttpHeader('Accept', 'application/json');
		$I->sendPOST('/retrieve', [
			'number_id' => 102,
		]);
		$I->seeResponseCodeIs(200);
		$I->seeResponseIsJson();
		$I->seeResponseContainsJson([
			'number' => 14,
		]);
		$I->dontSeeResponseContainsJson([
			'id' => 102,
			'created_at' => date(DATE_RFC3339, 1392559495),
		]);
	}


	public function retrievePostFromJson(ApiTester $I)
	{
		$I->haveHttpHeader('Accept', 'application/json');
		$I->haveHttpHeader('Content-Type', 'application/json');
		$I->sendPOST('/retrieve', json_encode([
			'number_id' => 102,
		]));
		$I->seeResponseCodeIs(200);
		$I->seeResponseContainsJson([
			'number' => 14,
		]);
	}

	public function generatePostFromXml(ApiTester $I)
	{
		// TODO
	}

}
