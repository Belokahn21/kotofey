<?php

namespace app\widgets\fast_buy;

use app\models\entity\BasketItem;
use app\models\entity\Promo;
use Yii;
use app\models\entity\Basket;
use app\models\entity\Order;
use app\models\entity\OrdersItems;
use app\models\entity\User;
use app\models\tool\Debug;
use app\widgets\notification\Notify;

class FastBuyWidget extends \yii\base\Widget
{
	public $template = 'default';
	public $product;

	public function run()
	{
		$user = new User(['scenario' => User::SCENARIO_CHECKOUT]);

		if (\Yii::$app->request->isPost) {
			$db = Yii::$app->db;
			$transaction = $db->beginTransaction();
			if ($user->load(Yii::$app->request->post()) && $user->validate()) {
				if ($user->save() === false) {
					Notify::setErrorNotify(Debug::modelErrors($user));
					Yii::$app->controller->refresh();
				}

				Yii::$app->user->login($user, Yii::$app->params['users']['rememberMeDuration']);
			} else {
				$user = User::findOne(Yii::$app->user->id);
			}

			$item = new BasketItem();
			$item->setCount(1);
			$item->setName($this->product->name);
			$item->setProductId($this->product->id);
			$item->setPrice($this->product->price);

			$basket = new Basket();
			Basket::clear();
			$basket->add($item);

			$order = new Order();
			$order->user_id = $user->id;
			if ($order->validate() === false) {
				$transaction->rollBack();
				Notify::setErrorNotify(Debug::modelErrors($order));
				Yii::$app->controller->refresh();
			}

			if ($order->save() === false) {
				Notify::setErrorNotify(Debug::modelErrors($order));
				Yii::$app->controller->refresh();
				$transaction->rollBack();
				return false;
			}

			$items = new OrdersItems();
			$items->order_id = $order->id;
			if ($items->saveItems() === false) {
				$transaction->rollBack();
				Notify::setErrorNotify(Debug::modelErrors($items));
				Yii::$app->controller->refresh();
			}

			Basket::getInstance()->clear();
			Promo::clear();
			Notify::setSuccessNotify('Вы успешно купили товар');
			$transaction->commit();
			Yii::$app->controller->refresh();
		}


		return $this->render($this->template, [
			'user' => $user,
			'product' => $this->product,
		]);
	}

	public function init()
	{
		return;
	}
}