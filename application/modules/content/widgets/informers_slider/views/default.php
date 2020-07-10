<?php

use app\modules\catalog\models\entity\ProductPropertiesValues;

/* @var $providers \yii\db\ActiveQuery */

?>
<?php if ($this->beginCache('providers-cache', ['duration' => 3600 * 24 * 7])): ?>
    <div class="page-title__group">
        <h2 class="page-title">Категории</h2>
        <a class="page-title__link" href="/catalog/">Весь каталог</a>
    </div>
    <div class="category-slider-outter">
    <div class="swiper-container category-slider-container">
        <div class="swiper-wrapper category-slider-wrapper">
            <?php foreach ($providers->all() as $provider): ?>
                <div class="swiper-slide category-slider__slide">
                    <div class="category-slider__info">
                        <div class="category-slider__title"><?=$provider->name;?></div>
                        <div class="category-slider__label"><?= ProductPropertiesValues::find()->where(['value' => $provider->id])->count('product_id'); ?> позиций</div>
                    </div>
                    <div class="category-slider__icon">
                        <img src="/upload/<?= $provider->image; ?>" alt="<?= $provider->name; ?>" title="<?= $provider->name; ?>">
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
        <div class="slider-swiper-button-next category-slider-control"><img src="/upload/images/arrow-right-black.svg">
        </div>
        <div class="slider-swiper-button-prev category-slider-control"><img src="/upload/images/arrow-left-black.svg">
        </div>
    </div>
    <?php $this->endCache(); ?>
<?php endif; ?>