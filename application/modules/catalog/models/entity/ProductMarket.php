<?php

namespace app\modules\catalog\models\entity;

use app\modules\catalog\models\entity\Offers;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "product_market".
 *
 * @property int $id
 * @property int $product_id
 * @property int $market_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Offers $product
 */
class ProductMarket extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'product_market';
	}

	public function behaviors()
	{
		return [
			TimestampBehavior::className()
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['product_id', 'market_id'], 'required'],
			[['product_id', 'market_id', 'created_at', 'updated_at'], 'integer'],
			[['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Offers::className(), 'targetAttribute' => ['product_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'product_id' => 'Product ID',
			'market_id' => 'Market ID',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getProduct()
	{
		return $this->hasOne(Offers::className(), ['id' => 'product_id']);
	}

	public static function hasStored($product_id)
	{
		return static::findOne(['product_id' => $product_id]);
	}
}
