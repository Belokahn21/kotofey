<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 16:02
 */

namespace app\models\entity;


use app\models\tool\Notice;
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
			[['price', 'count', 'product_id', 'order_id'], 'integer']
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
		/* @var $item BasketItem */
		foreach (Basket::findAll() as $item) {
			$self = new OrdersItems();
			$self->name = $item->getName();

			if ($item->getProduct()->id) {
				$self->product_id = $item->getProduct()->id;
			}

			$self->count = $item->getCount();
			$self->order_id = $this->order_id;
			$self->price = $item->getCount() * $item->getPrice();
			if ($self->validate()) {
				if ($self->save() === false) {
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