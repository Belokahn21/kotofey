<?php

use app\models\tool\Price;
use app\models\tool\Currency;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\basket\widgets\addBasket\AddBasketWidget;

/* @var $model \app\modules\catalog\models\entity\Product */
?>
<div class="swiper-slide vitrine__slide">
    <img class="vitrine__image" src="<?= ProductHelper::getImageUrl($model) ?>">
    <div class="vitrine__title">
        <a class="vitrine__link" href="<?= $model->detail; ?>"><?= $model->name; ?></a>
    </div>
    <div class="vitrine__properties">
        <ul class="light-properties">
            <li class="light-properties__item">
                <div class="light-properties__label">Размер</div>
                <div class="light-properties__value">250*120*65мм</div>
            </li>
            <li class="light-properties__item">
                <div class="light-properties__label">Артикул</div>
                <div class="light-properties__value"><?= $model->article; ?></div>
            </li>
        </ul>
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