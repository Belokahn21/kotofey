<?php

namespace app\widgets;

use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrdersItems;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\models\entity\Product;
use yii\helpers\Json;

class SelectProductDropdown extends \yii\base\Widget
{
    /* @var $model Order */
    public $model, $attribute;

    public function run()
    {
        $products = Product::find()->all();

        $items = [];
        /* @var $product Product */
        foreach ($products as $product) {
            $items[$product->id] = $product;
        }

        \Yii::$app->view->registerJs("var products = " . Json::encode($items) . ";", \yii\web\View::POS_HEAD);

        return Html::activeDropDownList($this->model, $this->attribute, ArrayHelper::map($products, 'id', 'name'), [
            'multiple' => 'multiple',
            'size' => '19',
            'class' => 'block-item select-items-new-order',
        ]);
    }
}