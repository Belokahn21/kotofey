<?php

use app\modules\site\models\tools\Price;
use app\modules\site\models\tools\Currency;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\basket\widgets\addBasket\AddBasketWidget;
use app\modules\catalog\widgets\PreviewProperties\PreviewPropertiesWidget;

/* @var $models \app\modules\catalog\models\entity\Product[]
 * @var $this \yii\web\View
 * @var $title string
 * @var $subTitle string
 * @var $link string
 * @var $linkTitle string
 * @var $uniqKey string
 */

?>
<?php if ($models): ?>
    <?php if ($this->beginCache(md5($title . $uniqKey), ['duration' => 3600 * 24 * 7])): ?>
        <div class="page-title__group">
            <h2 class="page-title"><?= $title; ?></h2>

            <?php if (!empty($subTitle)): ?>
                <div class="page-title__note"><?= $subTitle; ?></div>
            <?php endif; ?>

            <?php if (!empty($link) && !empty($linkTitle)): ?>
                <a class="page-title__link" href="<?= $link; ?>"><?= $linkTitle; ?></a>
            <?php endif; ?>
        </div>
        <div class="swiper-container vitrine-container">
            <div class="swiper-wrapper vitrine-wrapper">

                <?php foreach ($models as $model): ?>
                    <div class="swiper-slide vitrine__slide">

                        <?php if ($percent = ProductHelper::getPercent($model)): ?>
                            <div class="discount">- <?= $percent; ?>%</div>
                        <?php endif; ?>

                        <img class="vitrine__image swiper-lazy" data-src="<?= ProductHelper::getImageUrl($model, false, ['width' => 250, 'height' => 300, 'crop' => 'fit']); ?>" alt="<?= $model->name; ?>" title="<?= $model->name; ?>">
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
                            <span class="amount"><?= Price::format($model->getPrice()); ?></span>
                            <span class="rate"><?= Currency::getInstance()->show(); ?> / шт </span></div>
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
            <div class="vitrine-swiper-pagination"></div>
        </div>
        <?php $this->endCache(); endif; ?>
<?php endif; ?>
