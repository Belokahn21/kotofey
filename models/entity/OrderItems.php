<?
/**
 * Developer: Konstantin Vasin by PhpStorm
 * Company: Altasib
 * Time: 16:02
 */

namespace app\models\entity;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * OrderItems model
 *
 * @property integer $id
 * @property integer $orderId
 * @property integer $productId
 * @property integer $count
 * @property integer $summ
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Product $product
 */
class OrderItems extends ActiveRecord
{
	public static function tableName()
	{
		return "order_items";
	}

	public function rules()
	{
		return [
			[['summ', 'count', 'productId', 'orderId'], 'integer']
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
		$basket = new Basket();
		foreach ($basket->listItems() as $item) {
			$self = new OrderItems();
			$self->productId = $item->product->id;
			$self->count = $item->count;
			$self->orderId = $this->orderId;
			$self->summ = $item->count * $item->product->price;
			if ($self->validate()) {
				if ($self->save() === false) {
					return false;
				}
			} else {
				return false;
			}
		}

		return true;
	}

	public function getProduct()
	{
		return Product::findOne($this->productId);
	}
}