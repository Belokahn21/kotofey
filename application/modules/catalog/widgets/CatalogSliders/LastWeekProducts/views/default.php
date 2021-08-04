<?php

use app\modules\site\models\tools\PriceTool;
use app\modules\site\models\tools\Currency;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\basket\widgets\addBasket\AddBasketWidget;
use app\modules\catalog\models\helpers\DiscountItemsWidgetHelper;
use app\modules\catalog\widgets\PreviewProperties\PreviewPropertiesWidget;

/* @var $models \app\modules\catalog\models\entity\Product[]
 * @var $formatArray array
 * @var $this \yii\web\View
 */

?>

<?php if ($models): ?>
    <?php if ($this->beginCache('last-week-items-widget', ['duration' => 3600 * 24 * 7])): ?>
        <div class="page-title__group">
            <h2 class="page-title">Новинки недели</h2>
            <a class="page-title__link" href="/catalog/">Все предложения</a>
        </div>
        <div class="swiper-container vitrine-container">
            <div class="swiper-wrapper vitrine-wrapper">
                <?php foreach ($models as $model): ?>
                    <div class="swiper-slide vitrine__slide">
                        <?php if ($model->discount_price): ?>
                            <div class="discount">- <?= ProductHelper::getPercent($model); ?>%</div>
                        <?php endif; ?>
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
                            <?php if ($model->discount_price): ?>
                                <span class="amount-old"><?= PriceTool::format($model->getPrice()); ?></span>
                                <span class="amount"><?= PriceTool::format($model->getDiscountPrice()); ?></span>
                            <?php else: ?>
                                <span class="amount"><?= PriceTool::format($model->getPrice()); ?></span>
                            <?php endif; ?>
                            <span class="rate"><?= Currency::getInstance()->show(); ?> / шт</span>
                        </div>
                        <?= AddBasketWidget::widget([
                            'product' => $model,
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
