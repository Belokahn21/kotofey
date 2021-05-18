<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use app\modules\site\models\tools\Currency;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\promotion\models\helpers\PromotionHelper;

/* @var $models \app\modules\promotion\models\entity\Promotion[] */
?>

<h2>Обратите внимание на товары по акции</h2>
<div class="swiper-container current-promotions-slider">
    <div class="swiper-wrapper">
        <?php foreach ($models as $model): ?>
            <div class="swiper-slide current-promotions-slider__slide">
                <div class="current-promotions-slider__side">
                    <?= Html::img(PromotionHelper::getImageUrl($model), ['class' => 'current-promotions-slider__image']); ?>
                </div>
                <div class="current-promotions-slider__side">
                    <div class="swiper-container vertical-promo-products-slider">
                        <div class="swiper-wrapper">
                            <?php foreach ($model->promotionProductMechanics as $mechanic): ?>
                                <div class="swiper-slide vertical-promo-products-slider__slide">
                                    <img class=" vertical-promo-products-slider__image" src="<?= ProductHelper::getImageUrl($mechanic->product); ?>" alt="<?= $mechanic->product->name; ?>">
                                    <a href="<?= ProductHelper::getDetailUrl($mechanic->product); ?>" class=" vertical-promo-products-slider__name"><?= StringHelper::truncate($mechanic->product->name, 25, '...'); ?></a>
                                    <div class=" vertical-promo-products-slider__price"><?= $mechanic->product->price; ?><?= Currency::getInstance()->show(); ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>


