<?php

use app\models\tool\Price;
use app\models\tool\Currency;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\basket\widgets\addBasket\AddBasketWidget;
use app\modules\catalog\widgets\preview_properties\PreviewPropertiesWidget;
use app\modules\favorite\models\entity\Favorite;

/* @var $product \app\modules\catalog\models\entity\Product */

$isDiscount = $product->discount_price > 0;
?>


<li class="catalog__item">
    <div class="catalog-actions">
		<?php if (Favorite::getInstance()->exist($product->id)): ?>
            <div class="catalog-favorite js-toggle-class js-add-favorite" data-class-target="far fa-heart" data-product-id="<?= $product->id; ?>">
                <i class="fas fa-heart"></i>
            </div>
		<?php else: ?>
            <div class="catalog-favorite js-toggle-class js-add-favorite" data-class-target="fas fa-heart" data-product-id="<?= $product->id; ?>">
                <i class="far fa-heart"></i>
            </div>
		<?php endif; ?>
    </div>
	<?php if ($isDiscount): ?>
        <div class="catalog__discount"><span>-<?= ProductHelper::getPercent($product); ?>%</span></div>
	<?php endif; ?>
    <img class="catalog__image" src="<?= ProductHelper::getImageUrl($product); ?>">
    <div class="catalog__title">
        <a class="catalog__link" href="<?= $product->detail; ?>"><?= $product->name; ?></a>
    </div>
	<?= PreviewPropertiesWidget::widget([
		'product' => $product
	]); ?>
    <div class="catalog__price-group">
		<?php if ($isDiscount): ?>
            <div class="catalog__old-price"><?= Price::format($product->price); ?></div>
            <div class="catalog__new-price"><?= Price::format($product->discount_price); ?></div>
		<?php else: ?>
            <div class="catalog__price"><?= Price::format($product->price); ?></div>
		<?php endif; ?>
        <div class="catalog__rate"><?= Currency::getInstance()->show(); ?> / шт</div>
    </div>
	<?= AddBasketWidget::widget([
		'product_id' => $product->id,
		'price' => $product->price,
		'showInfo' => false,
		'showOneClick' => false,
		'showControl' => false,
		'showButton' => true,
	]) ?>
</li>