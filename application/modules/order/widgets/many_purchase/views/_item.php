<?php

use app\models\tool\Price;
use app\models\tool\Currency;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\basket\widgets\addBasket\AddBasketWidget;
use app\modules\catalog\widgets\preview_properties\PreviewPropertiesWidget;

/* @var $model \app\modules\catalog\models\entity\Product */
?>
<div class="swiper-slide vitrine__slide">
    <img class="vitrine__image swiper-lazy" data-src="<?= ProductHelper::getImageUrl($model, false, ['width' => 250, 'height' => 300, 'crop' => 'fit']); ?>" alt="<?= $model->name; ?>" title="<?= $model->name; ?>">
    <div class="swiper-lazy-preloader"></div>
    <div class="vitrine__title">
        <a class="vitrine__link" href="<?= ProductHelper::getDetailUrl($model); ?>"><?= $model->name; ?></a>
    </div>
    <div class="vitrine__properties">
        <?= PreviewPropertiesWidget::widget([
            'product' => $model
        ]); ?>
    </div>
    <div class="vitrine__price">
        <span class="amount"><?= Price::format($model->price); ?></span>
        <span class="rate"><?= Currency::getInstance()->show(); ?> / шт </span></div>
    <?= AddBasketWidget::widget([
        'product_id' => $model->id,
        'price' => $model->price,
        'showInfo' => false,
        'showOneClick' => false,
        'showControl' => false,
        'showButton' => true,
    ]) ?>
</div>