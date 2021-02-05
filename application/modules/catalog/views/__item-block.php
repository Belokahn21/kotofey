<?php

use app\modules\site\models\tools\Price;
use app\modules\site\models\tools\Currency;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\basket\widgets\addBasket\AddBasketWidget;
use app\modules\catalog\widgets\PreviewProperties\PreviewPropertiesWidget;
use app\modules\favorite\models\entity\Favorite;
use app\modules\catalog\models\helpers\ProductOrderHelper;

/* @var $product \app\modules\catalog\models\entity\Product */

$isDiscount = $product->getDiscountPrice() > 0;
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

        <?php if ($timeDelivery = ProductOrderHelper::getProductDelivery($product->id)): ?>
            <div class="catalog-order" data-toggle="tooltip" data-placement="top" rel="tooltip" title="Этот товар доставляется от <?= $timeDelivery->start; ?> до <?= $timeDelivery->end; ?> дней"><i class="far fa-calendar-alt"></i></div>
        <?php endif; ?>
    </div>
    <?php if ($isDiscount): ?>
        <div class="catalog__discount"><span>-<?= ProductHelper::getPercent($product); ?>%</span></div>
    <?php endif; ?>
    <a href="<?= ProductHelper::getDetailUrl($product); ?>">
        <img title="<?= $product->name; ?>" alt="<?= $product->name; ?>" class="catalog__image" src="<?= ProductHelper::getImageUrl($product, false, array("width" => 246, "height" => 300, "crop" => "fit")); ?>">
    </a>
    <div class="catalog__title">
        <a class="catalog__link" href="<?= ProductHelper::getDetailUrl($product); ?>"><?= $product->name; ?></a>
    </div>
    <?= PreviewPropertiesWidget::widget([
        'product' => $product
    ]); ?>
    <div class="catalog__price-group">
        <?php if ($isDiscount): ?>
            <div class="catalog__old-price"><?= Price::format($product->getPrice()); ?></div>
            <div class="catalog__new-price"><?= Price::format($product->getDiscountPrice()); ?></div>
        <?php else: ?>
            <div class="catalog__price"><?= Price::format($product->getPrice()); ?></div>
        <?php endif; ?>
        <div class="catalog__rate"><?= Currency::getInstance()->show(); ?> / шт</div>
    </div>
    <?= AddBasketWidget::widget([
        'product' => $product,
        'price' => ProductHelper::getResultPrice($product),
        'showInfo' => false,
        'showOneClick' => false,
        'showControl' => false,
        'showButton' => true,
    ]) ?>
</li>