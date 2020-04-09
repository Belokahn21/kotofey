<?php

namespace app\modules\promo\models\form;


use app\models\entity\Product;
use app\models\entity\ProductPropertiesValues;
use phpDocumentor\Reflection\Types\Integer;
use yii\base\Model;

class PromoForm extends Model
{
    public $product_id;
    public $discount;

    private $_products;

    public function rules()
    {
        return [
            [['discount', 'product_id'], 'required'],
            [['product_id'], 'string'],
            [['discount'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'product_id' => 'Товары в акции',
            'discount' => 'Скидка',
        ];
    }

    public function createPromo($promoValueId)
    {
        $this->parseProductIds();
        $this->clean();

        $products = Product::find()->where(['code' => $this->_products]);

        $products = $products->all();

        if (!$products) {
            return false;
        }


        /* @var $product Product */
        foreach ($products as $product) {
            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;
            $product->discount_price = $product->price - ceil($product->price * ($this->discount / 100));

            $productPropertiesValues = new ProductPropertiesValues();
            $productPropertiesValues->product_id = $product->id;
            $productPropertiesValues->property_id = 11;
            $productPropertiesValues->value = strval($promoValueId);

            if ($productPropertiesValues->validate()) {
                if (!$productPropertiesValues->save()) {
                    print_r(33);
                    return false;
                }
            } else {
                print_r($productPropertiesValues->getErrors());
                print_r(11);
                return false;
            }

            if ($product->validate()) {
                if (!$product->save()) {
                    print_r(44);
                    return false;
                }
            } else {
                print_r(22);
                return false;
            }
        }

        return true;
    }

    private function clean()
    {
        foreach ($this->_products as $key => $value) {
            $this->_products[$key] = str_replace(array("\n", "\r"), '', $value);
            if (strlen($value) == 1 or empty($value)) {
                unset($this->_products[$key]);
            }
        }
    }

    private function parseProductIds()
    {
        $this->_products = explode("\r", $this->product_id);
    }
}