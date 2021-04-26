<?php

use app\modules\site\models\tools\Currency;
use app\modules\catalog\models\helpers\ProductHelper;

/* @var $models \app\modules\catalog\models\entity\Product[] */

?>

<?php if ($models): ?>
    <?php if ($this->beginCache('many-purchase-items-widget-interested', ['duration' => 3600 * 24 * 7])): ?>
        <div class="swiper-container steam-slider-container">
            <div class="swiper-wrapper steam-slider-wrapper">
                <?php foreach ($models as $model): ?>
                    <div class="swiper-slide steam-slider-slide">
                        <div class="swiper-slide steam-slider-slide__side">
                            <div class="swiper-container steam-slider-top-container">
                                <div class="swiper-wrapper steam-slider-top-wrapper">
                                    <div class="swiper-slide"><img src="<?= ProductHelper::getImageUrl($model) ?>" alt="<?= $model->name; ?>"/></div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide steam-slider-slide__side">
                            <div class="steam-slider-thumbs__title page-title"><?= $model->name; ?></div>
                            <div class="swiper-container steam-slider-thumbs-container">
                                <div class="swiper-wrapper steam-slider-thumbs-wrapper">
                                    <?php foreach (ProductHelper::getGalleryImages($model) as $image): ?>
                                        <div class="swiper-slide steam-slider-thumbs-slide"><img src="<?= $image; ?>" alt="<?= $model->name; ?>"/></div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="steam-slider-thumbs__description">
                                    <?= $model->description; ?>
                                </div>
                                <?php /* comment block hide
                                <div class="steam-slider-thumbs-reviews">
                                    <div class="steam-slider-thumbs-reviews__item">
                                        <div class="steam-slider-thumbs-reviews__author">Flyness22 говорит: Лучший корм в истории человечества. Наша собака безума от счастья когда ест этот замечательный корм!</div>
                                    </div>
                                </div> */ ?>
                                <div class="steam-slider-thumbs__price-group">
                                    <div class="steam-slider-thumbs__price"><?= $model->getPrice(); ?> <?= Currency::getInstance()->show(); ?></div>
                                    <?php /* what is pet
                                    <div class="steam-slider-thumbs__pet">
                                        <!--                                        <i class="fas fa-dog"></i>-->
                                        <!--i.fas.fa-cat-->
                                    </div>
 */ ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php $this->endCache(); endif; ?>
<?php endif; ?>
