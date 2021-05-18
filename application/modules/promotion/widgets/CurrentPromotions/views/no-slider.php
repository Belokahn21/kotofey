<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use app\modules\site\models\tools\Currency;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\promotion\models\helpers\PromotionHelper;

/* @var $models \app\modules\promotion\models\entity\Promotion[] */
?>

<?php foreach ($models as $model): ?>
    <div class="current-promotions-slider-group my-5">
        <div class="page-title__group">
            <h2 class="page-title"><?= $model->name; ?></h2>
            <a class="page-title__link" href="<?= PromotionHelper::getDetailUrl($model); ?>">Смотреть больше товаров</a>
        </div>
        <div class="swiper-container current-promotions-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide current-promotions-slider__slide">
                    <div class="current-promotions-slider__side">
                        <a href="<?= PromotionHelper::getDetailUrl($model); ?>">
                            <?= Html::img(PromotionHelper::getImageUrl($model), ['class' => 'current-promotions-slider__image']); ?>
                        </a>
                    </div>
                    <div class="current-promotions-slider__side">

                        <?php $limit = 15; ?>
                        <?php $sliced = $model->promotionProductMechanics; ?>
                        <?php if (count($model->promotionProductMechanics) > $limit): ?>
                            <?php $sliced = array_slice($model->promotionProductMechanics, 0, $limit) ?>
                        <?php endif; ?>

                        <div class="vertical-promo-products-slider-group">
                            <div class="swiper-container vertical-promo-products-slider">
                                <div class="swiper-wrapper">
                                    <?php foreach ($sliced as $mechanic): ?>
                                        <div class="swiper-slide vertical-promo-products-slider__slide">
                                            <img class=" vertical-promo-products-slider__image" src="<?= ProductHelper::getImageUrl($mechanic->product); ?>" alt="<?= $mechanic->product->name; ?>">
                                            <a href="<?= ProductHelper::getDetailUrl($mechanic->product); ?>" class=" vertical-promo-products-slider__name"><?= StringHelper::truncate($mechanic->product->name, 25, '...'); ?></a>
                                            <div class=" vertical-promo-products-slider__price"><?= $mechanic->product->price; ?><?= Currency::getInstance()->show(); ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php if (count($sliced) > 3): ?>
                                    <div class="swiper-pagination vertical-promo-products-slider-pagination"></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


