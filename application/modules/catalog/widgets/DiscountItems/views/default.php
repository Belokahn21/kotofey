<?php

use app\models\tool\Price;
use app\models\tool\Currency;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\basket\widgets\addBasket\AddBasketWidget;
use app\modules\catalog\models\helpers\DiscountItemsWidgetHelper;
use app\modules\catalog\widgets\preview_properties\PreviewPropertiesWidget;

/* @var $models \app\modules\catalog\models\entity\Product[]
 * @var $informersValues \app\modules\catalog\models\entity\SaveInformersValues[]
 * @var $formatArray array
 * @var $this \yii\web\View
 */

?>

<?php if ($models): ?>
    <?php if ($this->beginCache('discount-items-widget', ['duration' => 3600 * 24 * 7])): ?>
        <div class="page-title__group">
            <h2 class="page-title">Выгодные предложения</h2>
            <?php if (array_key_exists('brands', $formatArray) && array_key_exists('actions', $formatArray)): ?>
                <?php foreach ($formatArray['brands'] as $key => $brand): ?>
                    <a class="page-title__link" href="<?= DiscountItemsWidgetHelper::getUrl($formatArray['actions'], $key); ?>"><?= $brand['name']; ?></a>
                <?php endforeach; ?>
            <?php endif; ?>
            <a class="page-title__link" href="javascript:void(0);">Все предложения</a>
        </div>
        <div class="swiper-container vitrine-container">
            <div class="swiper-wrapper vitrine-wrapper">
                <?php foreach ($models as $model): ?>
                    <div class="swiper-slide vitrine__slide">
                        <div class="discount">- <?= ProductHelper::getPercent($model); ?>%</div>
                        <img class="vitrine__image swiper-lazy" data-src="<?= ProductHelper::getImageUrl($model, false, ['width' => 256, 'height' => 300, 'crop' => 'fit']); ?>" alt="<?= $model->name; ?>" title="<?= $model->image; ?>">
                        <div class="swiper-lazy-preloader"></div>
                        <div class="vitrine__title">
                            <a class="vitrine__link" href="<?= ProductHelper::getDetailUrl($model); ?>"><?= $model->name; ?></a>
                        </div>
                        <div class="vitrine__properties">
                            <?= PreviewPropertiesWidget::widget([
                                'product' => $model
                            ]); ?>
                        </div>
                        <div class="vitrine__price">
                            <span class="amount-old"><?= Price::format($model->getPrice()); ?></span>
                            <span class="amount"><?= Price::format($model->getDiscountPrice()); ?></span>
                            <span class="rate"><?= Currency::getInstance()->show(); ?> / шт</span>
                        </div>
                        <?= AddBasketWidget::widget([
                            'product' => $model,
                            'price' => $model->getPrice(),
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
        <?php $this->endCache(); endif; ?>
<?php endif; ?>
