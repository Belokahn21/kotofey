<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 14:22
 */

namespace app\models\entity;


use app\models\tool\payments\Robokassa;
use app\models\tool\Price;
use app\models\tool\vk\VKMethods;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;


/**
 * Order model
 *
 * @property integer $id
 * @property integer $user
 * @property integer $delivery
 * @property integer $payment
 * @property string $comment
 * @property integer $status
 * @property boolean $paid
 * @property string $promo_code
 * @property integer $created_at
 * @property integer $updated_at
 */
class Order extends ActiveRecord
{

	public $product_id;

	public static function tableName()
	{
		return "orders";
	}

	public function rules()
	{
		return [


			[['payment', 'delivery', 'user'], 'integer'],

			[['payment', 'delivery', 'user'], 'default', 'value' => 0],
			['paid', 'default', 'value' => false],
			['status', 'default', 'value' => 0],


			[['payment', 'delivery'], 'required', 'message' => 'Выберите {attribute}'],
			[['user'], 'required', 'message' => '{attribute} необходимо указать'],

			[['comment', 'promo_code'], 'string'],

			[['product_id'], 'safe'],
		];
	}

	public function behaviors()
	{
		return [
			TimestampBehavior::className()
		];
	}

	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'status' => 'Статус',
			'payment' => 'Способ оплаты',
			'delivery' => 'Способ доставки',
			'paid' => 'Оплачено',
			'user' => 'Покупатель',
			'cash' => 'Сумма заказа',
			'created_at' => 'Дата создания',
			'comment' => 'Комментарий к заказу',
			'product_id' => 'Товар',
			'promo_code' => 'Промо код',
		];
	}

	public function saveOrder()
	{
		if ($this->load(\Yii::$app->request->post())) {
			if ($this->validate()) {
				if ($this->save() === true) {
					$this->id = \Yii::$app->db->lastInsertID;
					return true;
				}
			}
		}
		return false;
	}

	public function cash()
	{
		$cash = false;
		$items = OrderItems::findAll(['orderId' => $this->id]);
		/* @var $promo Promo */
		$promo = Promo::findByCode($this->promo_code);
		foreach ($items as $item) {
			if ($promo) {
				$cash += $item->summ - (($item->summ * $promo->discount) / 100);
			} else {
				$cash += $item->summ;
			}
		}
		return $cash;
	}

	public function getCash()
	{
		return $this->cash();
	}

	public function allsum()
	{
		$orders = static::find()->all();
		$ids = ArrayHelper::getColumn($orders, 'id');
		return OrderItems::find()->where(['id' => $ids])->sum('summ');
	}

	public function ordersProfit()
	{
		$orders = static::find()->where(['paid' => true])->all();
		$items = OrderItems::find()->where(['id' => ArrayHelper::getColumn($orders, 'id')])->all();
		$products = Product::find()->where(['id' => ArrayHelper::getColumn($items, 'productId')]);
		return $products->sum('price') - $products->sum('purchase');
	}


	public function getStatus()
	{
		$status = null;
		if ($this->status == 0) {
			$status = new OrderStatus();
			$status->name = 'В обработке';
		} else {
			$status = OrderStatus::findOne($this->status);
		}

		return $status;
	}

	public function getPailink()
	{
		if ($this->paid == false) {
			$robokassa = new Robokassa();
			$robokassa->config->setInvID($this->id);
			$robokassa->config->setSum($this->getCash());
			return $robokassa->generateUrl();
		}

		return false;
	}

	public function getItems()
	{
		return Product::find()->where([
			'id' => ArrayHelper::getColumn(OrderItems::findAll(['orderId' => $this->id]), 'productId')
		])->all();
	}

	public function findByFilter($params)
	{
		if (!$params) {
			throw new \InvalidArgumentException("Empty params.");
		}
		if (\Yii::$app->user->isGuest) {
			throw new \Exception("Need auth user.");
		}

		$params['filter']['user'] = \Yii::$app->user->identity->id;

		return static::find()->where($params['filter'])->all();
	}

	public static function orderProfit()
	{
		$cash = 0;
		$orders = Order::find()->where(['paid' => 1])->all();


		/* @var $order Order */
		foreach ($orders as $order) {
			$cash += $order->cash();
		}

		return $cash;

	}

	public function hasAccess()
	{
		return $this->user == \Yii::$app->user->identity->id;
	}

	public function adminNotify()
	{
		$message = sprintf("На сайте " . $_SERVER['SERVER_NAME'] . " новый заказ! Сумма заказа: %sр. Подробнее по ссылке: https://" . $_SERVER['SERVER_NAME'] . "/admin/order/%s/",
			Price::format($this->cash()), $this->id);
		(new VKMethods())->sendUserMessage("111815168", $message);

		\Yii::$app->mailer->compose()
			->setFrom(\Yii::$app->params['email']['infoEmail'])
			->setTo('popugau@gmail.com')
			->setSubject('Новый заказ на ' . $_SERVER['SERVER_NAME'])
			->setHtmlBody(sprintf('Приятные новости! На сайте новый заказ на сумму %sр. Подробнее <a href="https://' . $_SERVER["SERVER_NAME"] . '/admin/order/%s/">по ссылке</a>',
				Price::format($this->cash()), $this->id))
			->send();
	}


	public function userNotify()
	{

		$robokassa = new Robokassa();
		$robokassa->invID = $this->id;
		$robokassa->sum = $this->cash();

		\Yii::$app->mailer->compose('userNotifyAboutCreatedOrder', [
			'order' => $this,
			'robokassa' => $robokassa,
		])
			->setFrom(\Yii::$app->params['email']['infoEmail'])
			->setTo(\Yii::$app->user->identity->email)
			->setSubject('Заказ на eventhorizont.ru')
			->send();
	}

	public function adminNotifyAboutOrderPaid($summ = null)
	{
		if ((int)$summ > 0) {
			$message = sprintf("По заказу #%s получена оплата в сумме %sр. Заказ оплачен. Информация о заказе http://eventhorizont.ru/admin/order/%s/",
				$this->id, Price::format($summ), $this->id);
			(new VKMethods())->sendUserMessage("111815168", $message);

			\Yii::$app->mailer->compose()
				->setFrom(\Yii::$app->params['email']['infoEmail'])
				->setTo(\Yii::$app->params['email']['mainEmail'])
				->setSubject('Оплата заказа на eventhorizont.ru')
				->setHtmlBody($message)
				->send();
		}
	}
}