<?php

use app\models\tool\Price;
use app\models\tool\Currency;
use app\modules\catalog\models\helpers\ProductHelper;

/* @var $models \app\modules\catalog\models\entity\Product[] */
?>

<?php if ($models): ?>
    <div class="page-title__group is-column">
        <h2 class="page-title">Выгодные предложения</h2>
        <a class="page-title__link" href="javascript:void(0);">Все предложения</a>
    </div>
    <div class="swiper-container vitrine-container">
        <div class="swiper-wrapper vitrine-wrapper">
            <?php foreach ($models as $model): ?>
                <div class="swiper-slide vitrine__slide">
                    <div class="discount">- <?= ProductHelper::getPercent($model); ?>%</div>
                    <img class="vitrine__image" src="/upload/<?= $model->image; ?>" alt="<?= $model->name; ?>" title="<?= $model->image; ?>">
                    <div class="vitrine__title">
                        <a class="vitrine__link" href="<?= $model->detail; ?>"><?= $model->name; ?></a>
                    </div>
                    <div class="vitrine__properties">
                        <ul class="light-properties">
                            <li class="light-properties__item">
                                <div class="light-properties__label">Размер</div>
                                <div class="light-properties__value">250*120*65мм</div>
                            </li>
                            <li class="light-properties__item">
                                <div class="light-properties__label">Артикул</div>
                                <div class="light-properties__value"><?= $model->article;?></div>
                            </li>
                        </ul>
                    </div>
                    <div class="vitrine__price">
                        <span class="amount-old"><?= Price::format($model->price); ?></span>
                        <span class="amount"><?= Price::format($model->discount_price); ?></span>
                        <span class="rate"><?= Currency::getInstance()->show(); ?> / шт</span>
                    </div>
                    <button class="is-white add-basket js-add-basket" type="button">
                        <img class="add-basket__icon" src="/upload/images/basket.png">
                        <span class="add-basket__label">В корзину</span>
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
<?php endif; ?>
