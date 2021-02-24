<?php

foreach (\app\modules\catalog\models\entity\Product::find()->where(['>', 'count', 0])->all() as $product) {
    echo $product->count . 'шт. - ' . $product->name;
    echo "<br>";
}