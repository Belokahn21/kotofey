<?php

namespace app\modules\order\models\entity;

use app\modules\basket\models\entity\Basket;
use app\modules\delivery\models\entity\Delivery;
use app\modules\catalog\models\entity\Product;
use app\modules\promo\models\entity\Promo;
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

    public $need_delete;
    public $promo_code;

    public function rules()
    {
        return [
            [['name', 'promo_code'], 'string'],

            [['price', 'count', 'product_id', 'order_id', 'weight', 'purchase'], 'integer'],

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

            $basket = new \app\modules\basket\models\entity\Basket();
            $basket->add($item);
        }

        $discount = null;
        $promo = null;
        if ($this->promo_code) {
            $promo = Promo::findOne(['code' => $this->promo_code]);

            if ($promo) {
                $discount = $promo->discount / 100;
            }
        }

        /* @var $item OrdersItems */
        foreach (Basket::findAll() as $item) {
            $item->order_id = $this->order_id;

            // применяется промокод
            if ($discount !== null) {
                $item->price = $item->price - ceil($item->price * $discount);
            }

            if ($item->validate()) {
                if ($item->save() === false) {
                    return false;
                }
                if ($promo instanceof \app\modules\promo\models\entity\Promo) {
                    \app\modules\promo\models\entity\Promo::minusCode($promo->code);
                }

            } else {
                return false;
            }

        }

        \app\modules\basket\models\entity\Basket::clear();

        $this->on(OrdersItems::EVENT_CREATE_ITEMS, ['app\modules\order\models\events\OrderEvents', 'noticeAboutCreateOrder'], [
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

    public function usePromoCode($code)
    {
        if ($promo = Promo::findByCode($code)) {
            if ($promo->count > 0) {
                $this->promo_code = $code;
            }
        }
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название товара',
            'count' => 'Количество',
            'price' => 'Цена',
            'purchase' => 'Закупочная цена',
            'product_id' => 'ID товара',
            'order_id' => 'ID заказа',
            'need_delete' => 'Удалить',
        ];
    }
}