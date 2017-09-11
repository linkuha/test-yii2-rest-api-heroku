<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\Linkable;

/**
 * This is the model class for table "{{%random_number}}".
 *
 * @property integer $id
 * @property integer $number
 * @property integer $created_at
 * @property integer $updated_at
 */
class RandomNumber extends ActiveRecord implements Linkable
{
	const RANDOM_MIN = 0;
	const RANDOM_MAX = 1000;

	public static function tableName()
	{
		return '{{%random_number}}';
	}

	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'number' => 'Random Number',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		];
	}

	public function behaviors()
	{
		return [
			TimestampBehavior::className(),
		];
	}

	public function fields()
	{
		return [
			'id' => 'id',
		];
	}

	// Use request parameter 'expand' for adding
	public function extraFields()
	{
		return [
			//'id' => 'id',
			'created_at' => function () {
				return date(DATE_RFC3339, $this->created_at);
			},
		];
	}

	public function getLinks()
	{
		return [
			'self' => $this->getLinkSelf(),
		];
	}

	public function getLinkSelf()
	{
		return Url::to(["retrieve/$this->id"], true);
	}

	public function generate($params)
	{
		$min = self::RANDOM_MIN;
		$max = self::RANDOM_MAX;

		if (isset($params['max']) && is_numeric($params['max'])) {
			$max = $params['max'];
			if (isset($params['min']) && is_numeric($params['min'])) {
				if ($max >= $params['min']) {
					$min = $params['min'];
				}
			}
		}
		$rand = mt_rand($min, $max);

		$this->number = $rand;
	}
}
