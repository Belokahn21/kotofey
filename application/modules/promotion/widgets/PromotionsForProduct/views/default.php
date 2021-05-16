<?php

use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\promotion\models\helpers\PromotionHelper;

/* @var $models \app\modules\promotion\models\entity\Promotion[] */
?>

<div class="product-promotions-title">
    Акции с этим товаром
</div>
<div class="product-promotions">
    <?php foreach ($models as $model): ?>
        <div class="product-promotions__item">
            <a href="<?= PromotionHelper::getDetailUrl($model); ?>" class="product-promotions__link">
                <img src="<?= PromotionHelper::getImageUrl($model); ?>">
            </a>

            <div class="swiper-container product-promotions-slider">
                <div class="swiper-wrapper">
                    <?php foreach ($model->promotionProductMechanics as $mechanics): ?>
                        <div class="swiper-slide">
                            <a href="<?= ProductHelper::getDetailUrl($mechanics->product) ?>">
                                <img src="<?= ProductHelper::getImageUrl($mechanics->product) ?>">
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
