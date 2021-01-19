<?php
/* @var $models \app\modules\catalog\models\entity\Product[] */
/* @var $this \yii\web\View */
?>
<?php if ($models): ?>

    <?php if ($this->beginCache('recomended-products', ['duration' => 3600 * 24 * 7])): ?>
        <div class="page-title__group">
            <h2 class="page-title">Рекомендуемые товары</h2>
        </div>
        <div class="swiper-container vitrine-container">
            <div class="swiper-wrapper vitrine-wrapper">
                <?php foreach ($models as $model): ?>
                    <?= $this->render('@app/modules/order/widgets/many_purchase/views/_item.php', [
                        'model' => $model
                    ]); ?>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <?php $this->endCache(); endif; ?>
<?php endif; ?>

