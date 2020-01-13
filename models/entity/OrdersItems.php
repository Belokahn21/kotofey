<?php

namespace app\models\entity;

use app\models\tool\Debug;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * OrderItems model
 *
 * @property integer $id
 * @property string $name
 * @property integer $order_id
 * @property integer $product_id
 * @property integer $count
 * @property integer $price
 * @property integer $weight
 * @property string $image
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Product $product
 */
class OrdersItems extends ActiveRecord
{
	const EVENT_CREATE_ITEMS = 'create_items';

	public function rules()
	{
		return [
			[['name'], 'string'],

			[['price', 'count', 'product_id', 'order_id', 'weight'], 'integer'],

			[['image'], 'file', 'skipOnEmpty' => true, 'extensions' => \Yii::$app->params['files']['extensions']],
		];
	}

	public function behaviors()
	{
		return [
			TimestampBehavior::className()
		];
	}

	public function saveItems()
	{
        if (Basket::getInstance()->cash() < Delivery::LIMIT_ORDER_SUMM_TO_ACTIVATE) {
            $item = new OrdersItems();
            $item->price = Delivery::PRICE_DELIVERY;
            $item->name = 'Доставка';
            $item->count = 1;

            $basket = new Basket();
            $basket->add($item);
        }

		/* @var $item OrdersItems */
		foreach (Basket::findAll() as $item) {

			Debug::printFile($item);

			$item->order_id = $this->order_id;

			if ($item->validate()) {
				if ($item->save() === false) {
					return false;
				}
			} else {
				return false;
			}

		}


		$this->on(OrdersItems::EVENT_CREATE_ITEMS, ['app\models\events\OrderEvents', 'noticeAboutCreateOrder'], [
				'order_id' => $this->order_id
			]
		);
		$this->trigger(OrdersItems::EVENT_CREATE_ITEMS);


		return true;
	}

	public function getProduct()
	{
		return Product::findOne($this->product_id);
	}
}