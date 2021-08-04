<?php

use yii\helpers\Url;
use app\modules\site\models\tools\PriceTool;
use app\modules\site\models\tools\Currency;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\basket\widgets\addBasket\AddBasketWidget;

/* @var $product \app\modules\catalog\models\entity\Product */
?>
<div class="catalog-line__item">
    <div class="catalog-line__image"><img src="<?= ProductHelper::getImageUrl($product); ?>" alt="<?= $product->name; ?>" title="<?= $product->name; ?>"></div>
    <div class="catalog-line__name">
        <a href="<?= ProductHelper::getDetailUrl($product); ?>"><?= $product->name; ?></a>
    </div>
    <div class="catalog-line__price"><?= PriceTool::format($product->price); ?><?= Currency::getInstance()->show(); ?></div>
    <div class="catalog-line__to-cart">
        <?= AddBasketWidget::widget([
            'product' => $product,
            'showInfo' => false,
            'showOneClick' => false,
            'showControl' => true,
            'showButton' => true,
            'showCompare' => true
        ]) ?>
    </div>
</div>