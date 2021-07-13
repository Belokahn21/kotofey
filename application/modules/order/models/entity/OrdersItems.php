<?php

namespace app\modules\order\models\entity;

use app\modules\basket\models\entity\Basket;
use app\modules\delivery\models\entity\Delivery;
use app\modules\catalog\models\entity\Offers;
use app\modules\site\models\tools\Debug;
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
 * @property Offers $product
 */
class OrdersItems extends ActiveRecord
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

        $this->on(OrdersItems::EVENT_CREATE_ITEMS, ['app\modules\order\models\events\OrderEvents', 'noticeAboutCreateOrder'], [
                'order_id' => $this->order_id
            ]
        );
        $this->trigger(OrdersItems::EVENT_CREATE_ITEMS);


        return true;
    }

    public function getProduct()
    {
        return Offers::findOne($this->product_id);
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
}