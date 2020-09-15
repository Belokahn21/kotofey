<?php

use app\models\tool\Price;
use app\models\tool\Currency;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\basket\widgets\addBasket\AddBasketWidget;

/* @var $models \app\modules\catalog\models\entity\Product[]
 * @var $informersValues \app\modules\catalog\models\entity\InformersValues[]
 * @var $formatArray array
 */
?>

<?php if ($models): ?>
    <div class="page-title__group is-column">
        <h2 class="page-title">Выгодные предложения</h2>
        <?php if (array_key_exists('brands', $formatArray) && array_key_exists('actions', $formatArray)): ?>
            <?php foreach ($formatArray['brands'] as $id => $brands): ?>
                <?php foreach ($brands as $brand): ?>
<!--                    <a class="page-title__link" href="/catalog/?CatalogFilter[informer][--><?php //= $formatArray['actions'][$id]->informer_id; ?><!--][]=--><?php //= $formatArray['actions'][$id]->id; ?><!--">--><?php //= $brand->name; ?><!--</a>-->
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <a class="page-title__link" href="javascript:void(0);">Все предложения</a>
    </div>
    <div class="swiper-container vitrine-container">
        <div class="swiper-wrapper vitrine-wrapper">
            <?php foreach ($models as $model): ?>
                <div class="swiper-slide vitrine__slide">
                    <div class="discount">- <?= ProductHelper::getPercent($model); ?>%</div>
                    <img class="vitrine__image" src="<?= ProductHelper::getImageUrl($model); ?>" alt="<?= $model->name; ?>" title="<?= $model->image; ?>">
                    <div class="vitrine__title">
                        <a class="vitrine__link" href="<?= $model->detail; ?>"><?= $model->name; ?></a>
                    </div>
                    <div class="vitrine__properties">
                        <ul class="light-properties">
                            <li class="light-properties__item">
                                <div class="light-properties__label">Артикул</div>
                                <div class="light-properties__value"><?= $model->article; ?></div>
                            </li>
                        </ul>
                    </div>
                    <div class="vitrine__price">
                        <span class="amount-old"><?= Price::format($model->price); ?></span>
                        <span class="amount"><?= Price::format($model->discount_price); ?></span>
                        <span class="rate"><?= Currency::getInstance()->show(); ?> / шт</span>
                    </div>
                    <?= AddBasketWidget::widget([
                        'product_id' => $model->id,
                        'price' => $model->price,
                        'showInfo' => false,
                        'showOneClick' => false,
                        'showControl' => false,
                        'showButton' => true,
                    ]) ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
<?php endif; ?>
