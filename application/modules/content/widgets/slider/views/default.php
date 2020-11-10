<?php

use yii\helpers\Html;
use app\modules\content\models\helpers\SlidersImagesHelper;

/* @var $images \app\modules\content\models\entity\SlidersImages[]
 * @var $use_carousel boolean
 */

?>
<?php if ($images): ?>
    <?php if ($this->beginCache('index-slider-html', ['duration' => 3600 * 24 * 7])): ?>
        <div class="swiper-container slider-container">
            <div class="swiper-wrapper slider-wrapper">
                <?php foreach ($images as $image): ?>
                    <div class="swiper-slide slider__slide">
                        <?= Html::img(SlidersImagesHelper::getImageUrl($image), ['class' => 'slider__image', 'alt' => $image->text, 'title' => $image->text]) ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-button-next slider-control"></div>
            <div class="swiper-button-prev slider-control"></div>
            <div class="slider-pagination"></div>
        </div>
        <?php $this->endCache(); endif; ?>
<?php endif; ?>
