<?php

use yii\helpers\Url;
use app\models\tool\Price;
use app\models\tool\Currency;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\basket\widgets\addBasket\AddBasketWidget;

/* @var $product \app\modules\catalog\models\entity\Product */
?>
<div class="catalog-line__item">
    <div class="catalog-line__image"><img src="<?= ProductHelper::getImageUrl($product); ?>" alt="<?= $product->name; ?>" name="<?= $product->name; ?>"></div>
    <div class="catalog-line__name">
        <a href="<?= ProductHelper::getDetailUrl($product); ?>"><?= $product->name; ?></a>
    </div>
    <div class="catalog-line__price"><?= Price::format($product->price); ?><?= Currency::getInstance()->show(); ?></div>
    <div class="catalog-line__to-cart">
        <?= AddBasketWidget::widget([
            'product_id' => $product->id,
            'price' => $product->getPrice(),
            'showInfo' => false,
            'showOneClick' => false,
            'showControl' => true,
            'showButton' => true,
        ]) ?>
    </div>
</div>