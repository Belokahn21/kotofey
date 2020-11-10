<?php

/* @var $models \app\modules\catalog\models\entity\Product[]
 * @var $informersValues \app\modules\catalog\models\entity\InformersValues[]
 */

?>

<?php if ($models): ?>
    <?php if ($this->beginCache('many-purchase-items-widget', ['duration' => 3600 * 24 * 7])): ?>
        <div class="page-title__group">
            <h2 class="page-title">Покупатели выбирают</h2>
            <?php if ($informersValues): ?>
                <?php foreach ($informersValues as $item): ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="swiper-container vitrine-container">
            <div class="swiper-wrapper vitrine-wrapper">
                <?php foreach ($models as $model): ?>
                    <?= $this->render('_item', [
                        'model' => $model
                    ]); ?>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <div class="swiper-container">
            <div class="swiper-wrapper"></div>
            <div class="swiper-pagination"></div>
        </div>
        <?php $this->endCache(); endif; ?>
<?php endif; ?>
