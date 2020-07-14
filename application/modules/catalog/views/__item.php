<?php

use app\modules\basket\models\entity\Basket;
use app\models\tool\Currency;
use app\modules\catalog\models\entity\ProductPropertiesValues;
use app\modules\bonus\models\helper\DiscountHelper;
use app\modules\catalog\models\helpers\ProductHelper;
use app\models\tool\Price;
use app\modules\bonus\models\services\BonusByBuyService;

/* @var $product \app\modules\catalog\models\entity\Product */

$isDiscount = $product->discount_price > 0;
?>


<li class="catalog__item">
    <?php if ($isDiscount): ?>
        <div class="catalog__discount"><span>-15%</span></div>
    <?php endif; ?>
    <img class="catalog__image" src="<?= ProductHelper::getImageUrl($product); ?>">
    <div class="catalog__title">
        <a class="catalog__link" href="<?= $product->detail; ?>"><?= $product->name; ?></a>
    </div>
    <ul class="light-properties">
        <li class="light-properties__item">
            <div class="light-properties__label">Размер</div>
            <div class="light-properties__value">250*120*65мм</div>
        </li>
        <li class="light-properties__item">
            <div class="light-properties__label">Артикул</div>
            <div class="light-properties__value"><?= $product->article; ?></div>
        </li>
    </ul>
    <div class="catalog__price-group">
        <?php if ($isDiscount): ?>
            <div class="catalog__old-price"><?= Price::format($product->price); ?></div>
            <div class="catalog__new-price"><?= Price::format($product->discount_price); ?></div>
        <?php else: ?>
            <div class="catalog__price"><?= Price::format($product->price); ?></div>
        <?php endif; ?>
        <div class="catalog__rate"><?= Currency::getInstance()->show(); ?> / шт</div>
    </div>
    <button class="add-basket js-add-basket" type="button" data-product-id="<?= $product->id; ?>" data-product-count="1">
        <img class="add-basket__icon" src="/upload/images/basket.png"/><span class="add-basket__label">В корзину</span>
    </button>
</li>