<?php

use yii\helpers\Html;
use app\modules\content\models\helpers\SlidersImagesHelper;

/* @var $data array */

?>
<?php if ($data): ?>
    <?php if ($this->beginCache('index-slider-html', ['duration' => 3600 * 24 * 7])): ?>
        <div class="swiper-container slider-container">
            <div class="swiper-wrapper slider-wrapper">
                <?php foreach ($data as $datum): ?>
                    <div class="swiper-slide slider__slide">
                        <?= Html::img($datum['imageUrl'], ['class' => 'slider__image', 'alt' => $datum['alt'], 'title' => $datum['title']]) ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-button-next slider-control"></div>
            <div class="swiper-button-prev slider-control"></div>
            <div class="slider-pagination"></div>
        </div>
        <?php $this->endCache(); endif; ?>
<?php endif; ?>
