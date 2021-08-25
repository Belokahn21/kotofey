<?php

use yii\helpers\Html;
use app\modules\content\models\helpers\SlidersImagesHelper;

/* @var $images \app\modules\content\models\entity\SlidersImages[]
 * @var $use_carousel boolean
 */

?>
<?php if ($images): ?>
    <?php if ($this->beginCache('about-slider', ['duration' => 3600 * 24 * 7])): ?>
        <div class="slider">
            <div class="swiper-container about-swiper-container">
                <div class="swiper-wrapper about-swiper-wrapper">
                    <?php foreach ($images as $image): ?>
                        <?= Html::img(SlidersImagesHelper::getImageUrl($image, ['width' => 400, 'height' => 600, 'crop' => 'fit']), ['class' => 'swiper-slide', 'alt' => $image->text, 'title' => $image->text]) ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="swiper-pagination about-swiper-pagination"></div>
        </div>
        <?php $this->endCache(); endif; ?>
<?php endif; ?>