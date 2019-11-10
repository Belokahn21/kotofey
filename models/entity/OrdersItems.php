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
//	public static function tableName()
//	{
//		return "orders_items";
//	}

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
        $basket = new Basket();
        foreach ($basket->listItems() as $item) {
            $self = new OrdersItems();
            $self->name = $item->product->name;

            if ($item->product->id) {
                $self->product_id = $item->product->id;
            }

            $self->count = $item->count;
            $self->order_id = $this->order_id;
            $self->price = $item->count * $item->product->price;
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
        return Product::findOne($this->product_id);
    }
}