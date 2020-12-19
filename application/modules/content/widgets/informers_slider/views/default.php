<?php

use yii\helpers\Url;
use app\modules\catalog\models\entity\SaveProductPropertiesValues;
use app\modules\catalog\models\helpers\ProductPropertiesValuesHelper;

/* @var $providers \yii\db\ActiveQuery */

?>
<?php if ($this->beginCache('providers-cache', ['duration' => 3600 * 24 * 7])): ?>
    <div class="page-title__group">
        <h2 class="page-title">Категории</h2>
        <a class="page-title__link" href="<?= Url::to(['/catalog/']) ?>">Весь каталог</a>
    </div>
    <div class="category-slider-outter">
        <div class="swiper-container category-slider-container">
            <div class="swiper-wrapper category-slider-wrapper">
                <?php foreach ($providers->all() as $provider): ?>
                    <div class="swiper-slide category-slider__slide">
                        <div class="category-slider__info">
                            <div class="category-slider__title">
                                <a class="category-slider__link" href="<?= $provider->link; ?>"><?= $provider->name; ?></a>
                            </div>
                            <div class="category-slider__label">
                                <?= Yii::$app->cache->getOrSet('count-provider-' . $provider->id, function () use ($provider) {
                                    return SaveProductPropertiesValues::find()->where(['value' => $provider->id])->count('product_id');
                                }); ?> позиций
                            </div>
                        </div>
                        <div class="category-slider__icon">
                            <img src="<?= ProductPropertiesValuesHelper::getImageUrl($provider, ['width' => 70, 'height' => 70, 'crop' => 'fit']); ?>" alt="<?= $provider->name; ?>" title="<?= $provider->name; ?>">
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
            <div class="slider-swiper-button-next category-slider-control"><img src="/upload/images/arrow-right-black.svg"></div>
            <div class="slider-swiper-button-prev category-slider-control"><img src="/upload/images/arrow-left-black.svg"></div>
        </div>
    </div>
    <?php $this->endCache(); ?>
<?php endif; ?>