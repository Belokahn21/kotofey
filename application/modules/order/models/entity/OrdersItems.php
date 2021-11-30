<?php

namespace app\modules\order\models\entity;

use app\modules\basket\models\entity\Basket;
use app\modules\basket\models\entity\interfaces\BasketItemInterface;
use app\modules\catalog\models\repository\ProductRepository;
use app\modules\delivery\models\entity\Delivery;
use app\modules\catalog\models\entity\Product;
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
 * @property integer $purchase
 * @property integer $price
 * @property integer $discount_price
 * @property integer $weight
 * @property string $image
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Product $product
 */
class OrdersItems extends ActiveRecord implements BasketItemInterface
{
    const EVENT_CREATE_ITEMS = 'create_items';

    public $need_delete;

    public function rules()
    {
        return [
            [['name'], 'string'],

            [['price', 'count', 'product_id', 'order_id', 'weight', 'purchase', 'discount_price'], 'integer'],

            [['need_delete'], 'boolean'],

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
            $item->purchase = Delivery::PRICE_DELIVERY;
            $item->name = 'Доставка';
            $item->count = 1;

            $basket = new Basket();
            $basket->add($item);
        }


        /* @var $item OrdersItems */
        foreach (Basket::findAll() as $item) {
            $item->order_id = $this->order_id;
            if (!$item->validate() or !$item->save()) return false;

        }

        Basket::clear();


        return true;
    }

    public function getResultPrice()
    {
        return $this->discount_price ?: $this->price;
    }

    public function getProduct()
    {
        return ProductRepository::getOne($this->product_id);
    }

    public static function findByOrderId($order_id)
    {
        return static::find()->where(['order_id' => $order_id])->all();
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название товара',
            'count' => 'Количество',
            'price' => 'Цена',
            'purchase' => 'Закупочная цена',
            'discount_price' => 'Цена со скидкой',
            'product_id' => 'ID товара',
            'order_id' => 'ID заказа',
            'need_delete' => 'Удалить',
        ];
    }

    public function setId($id)
    {
        // TODO: Implement setId() method.
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName(string $name)
    {
        // TODO: Implement setName() method.
    }

    public function getName()
    {
        // TODO: Implement getName() method.
    }

    public function setCount(int $count)
    {
        // TODO: Implement setCount() method.
    }

    public function getCount()
    {
        // TODO: Implement getCount() method.
    }

    public function setPrice(int $price)
    {
        // TODO: Implement setPrice() method.
    }

    public function getPrice()
    {
        // TODO: Implement getPrice() method.
    }

    public function setWeight(float $price)
    {
        // TODO: Implement setWeight() method.
    }

    public function getWeight()
    {
        // TODO: Implement getWeight() method.
    }
}