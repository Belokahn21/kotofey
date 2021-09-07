<?php

use yii\helpers\Html;

/* @var $data array */

?>
<?php if ($data): ?>
    <?php if ($this->beginCache('index-combine-slider-html', ['duration' => Yii::$app->params['cache_time']])): ?>
        <div class="swiper-container slider-container">
            <div class="swiper-wrapper slider-wrapper">
                <?php foreach ($data as $datum): ?>
                    <?php if (!empty($datum['link'])): ?>

                        <a href="<?= $datum['link'] ?>" class="swiper-slide slider__slide">
                            <?= Html::img($datum['imageUrl'], ['class' => 'slider__image', 'alt' => $datum['alt'], 'title' => $datum['title']]) ?>
                        </a>

                    <?php else: ?>

                        <div class="swiper-slide slider__slide">
                            <?= Html::img($datum['imageUrl'], ['class' => 'slider__image', 'alt' => $datum['alt'], 'title' => $datum['title']]) ?>
                        </div>

                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="swiper-button-next slider-control"></div>
            <div class="swiper-button-prev slider-control"></div>
            <div class="slider-pagination"></div>
        </div>
        <?php $this->endCache(); endif; ?>
<?php endif; ?>
