<?php

namespace app\modules\catalog\models\helpers;

use app\modules\catalog\models\entity\Product;
use yii\helpers\Html;
use app\modules\order\models\entity\OrdersItems;

class HtmlProductHelper
{
    public static function showHtmlCountBuy(Product $product)
    {
        $count = OrdersItems::find()->where(['product_id' => $product->id])->count();
        if ($count > 0) return Html::tag('div', \Yii::t('app', 'Товар купили более  {n, plural, =0{0 раз} =1{одного раза} other{# раз}}!', array(
            'n' => $count,
        )), ['class' => 'product-count-buy']);


        return false;
    }
}