<?php

use yii\helpers\Html;

/* @var $images \app\models\entity\SlidersImages[] */
/* @var $use_carousel boolean */

?>
<?php if ($images): ?>
    <?php if ($this->beginCache('square-slider', ['duration' => 3600 * 24 * 7])): ?>
        <div id="square-slider-id" class="carousel slide main-page-slider" data-ride="carousel">
            <div class="carousel-inner">
                <?php $iterator = 1; ?>
                <?php foreach ($images as $image): ?>
                    <div class="carousel-item main-page-slider__item <?= ($iterator == 1 ? 'active' : ''); ?>">
                        <a href="<?= (!empty($image->link) ? $image->link : 'javascript:void(0);'); ?>">
                            <img class="d-block w-100 h-100" src="/upload/<?= $image->image; ?>" alt="<?= $image->text; ?>">
                        </a>
                    </div>
                    <?php $iterator++; ?>
                <?php endforeach; ?>
            </div>
            <?php if ($iterator > 2): ?>
                <a class="carousel-control-prev" href="#square-slider-id" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#square-slider-id" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            <?php endif; ?>
        </div>
        <?php $this->endCache(); endif; ?>
<?php endif; ?>
