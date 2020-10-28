<?php

use app\modules\content\models\helpers\SlidersImagesHelper;

/* @var $images \app\modules\content\models\entity\SlidersImages[] */
/* @var $use_carousel boolean */

?>
<?php if ($images): ?>
    <?php if ($this->beginCache('square-slider' . date("d.m.y"), ['duration' => 3600 * 24 * 7])): ?>
        <div class="mini-slider-container swiper-container">
            <div class="mini-slider-wrapper swiper-wrapper">
                <?php foreach ($images as $image): ?>
                    <div class="swiper-slide mini-slider-slide">
                        <img src="<?= SlidersImagesHelper::getImageUrl($image, ['width' => 400, 'height' => 400, 'crop' => 'fit']); ?>" alt="<?= $image->text; ?>">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php $this->endCache(); endif; ?>
<?php endif; ?>