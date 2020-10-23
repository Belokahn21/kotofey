<?php

use yii\helpers\Html;
use app\modules\content\models\helpers\SlidersImagesHelper;

/* @var $images \app\modules\content\models\entity\SlidersImages[]
 * @var $use_carousel boolean
 */

?>
<?php if ($images): ?>
    <?php if ($this->beginCache('index-slider_' . date("d.m.y"), ['duration' => 3600 * 24 * 7])): ?>
        <div class="swiper-container slider-container">
            <div class="swiper-wrapper slider-wrapper">
                <?php foreach ($images as $image): ?>
                    <div class="swiper-slide slider__slide">
                        <?php /*
                        <div class="slider__info"><p class="slider__h-1">BOSH GBH 240 (2.7 Дж)</p>
                            <p class="slider__h-2">Купи Bosh<br>и е... перфорируй!</p>
                            <p class="slider__h-3">7 935 P</p>
                        </div>*/ ?>
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
