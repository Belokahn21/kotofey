<?php

namespace app\models\forms;


use app\models\entity\Basket;
use app\models\entity\OrdersItems;
use app\models\entity\Product;
use app\models\helpers\PackProductHelper;
use app\models\helpers\ProductHelper;
use yii\base\Model;

class WeightBuyForm extends Model
{
    public $product_id;
    public $pack_id;
    public $amount;

    public function rules()
    {
        return [
            [['amount', 'product_id'], 'required'],

            [['amount', 'product_id'], 'integer'],

            [['pack_id'], 'string']
        ];
    }

    public function addBasket()
    {
        if ($this->validate()) {
            $product = Product::findOne($this->product_id);
            if (!$product) {
                throw new \Exception('Ошибка №1');
            }

            $basket = new Basket();
            $item = new OrdersItems();
            $item->name = $product->name;
            $item->weight = $this->amount;
            $item->product_id = $this->product_id;
            $item->price = ProductHelper::getPriceByWeight($product, $this->amount);
            $item->count = 1;

            $basket->add($item);

            $pack = PackProductHelper::findByPrimary($this->pack_id);
            if ($pack) {
                $pack_item = new OrdersItems();
                $pack_item->name = $pack->name;
                $pack_item->count = 1;
                $pack_item->price = $pack->price;
                $pack_item->image = $pack->image;


                $basket->add($pack_item);
            }

        }
    }
}