<?php

use app\modules\site\models\helpers\ImageHelper;
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
                <img class="product-promotions__action-img" src="<?= PromotionHelper::getImageUrl($model); ?>">
            </a>

            <div class="swiper-container product-promotions-slider">
                <div class="swiper-wrapper">
                    <?php foreach ($model->promotionProductMechanics as $mechanics): ?>
                        <div class="swiper-slide">
                            <?php if ($product = $mechanics->product): ?>
                                <a href="<?= ProductHelper::getDetailUrl($product) ?>">
                                    <img class="product-promotions__image" src="<?= ProductHelper::getImageUrl($product) ?>" alt="<?= $product->name; ?>" title="<?= $product->name; ?>">
                                </a>
                            <?php else: ?>
                                <img class="product-promotions__image" src="<?= ImageHelper::notFoundImage() ?>">
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
