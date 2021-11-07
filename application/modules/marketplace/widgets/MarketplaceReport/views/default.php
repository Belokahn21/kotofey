<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\marketplace\models\api\OzonApi;

/* @var $this \yii\web\View */
?>

<?php if ($this->beginCache('report-widget', ['duration' => Yii::$app->params['cache_time']])): ?>
    Список товаров площадки
    <?php $api = new OzonApi(); ?>
    <div class="marketplace-products">
        <?php $ozon_stocks = $api->ozonProductList(); ?>
        <?php foreach ($api->getProducts() as $ozon_element) : ?>
            <?php $product = Product::findOne(['article' => ArrayHelper::getValue($ozon_element, 'offer_id')]); ?>
            <?php $product_ozon_stock = false; ?>
            <?php foreach ($ozon_stocks as $item) : ?>
                <?php if (ArrayHelper::getValue($item, 'offer_id') == $product->article) $product_ozon_stock = $item; ?>
            <?php endforeach; ?>

            <?php $status = ''; ?>
            <?php $ozon_items = ArrayHelper::getValue($product_ozon_stock, 'stocks'); ?>
            <?php if ($ozon_items): ?>
                <?php foreach ($ozon_items as $st): ?>
                    <?php $presents = intval(ArrayHelper::getValue($st, 'present')); ?>
                    <?php if (($presents == $product->count) && $product->count > 0) $status = 'good'; ?>
                    <?php if (($presents > $product->count) && $product->count > 0) $status = 'warning'; ?>
                    <?php if (($presents < $product->count) && $product->count > 0) $status = 'can'; ?>
                <?php endforeach; ?>

                <div class="marketplace-products-item-wrap">
                    <div class="marketplace-products-item <?= $status; ?>">
                        <div class="marketplace-products-item-image-wrap">
                            <?= Html::img(ProductHelper::getImageUrl($product), ['class' => 'marketplace-products-item-image']); ?>
                        </div>
                        <a href="<?= Url::to(['/admin/catalog/product-backend/update', 'id' => $product->id]); ?>" target="_blank" class="marketplace-products-item__name"><?= $product->name; ?></a>
                        <div class="marketplace-products-item__stock marketplace">
                            <div>Склад: <?= $product->count; ?></div>
                            <?php foreach ($ozon_items as $st): ?>
                                <div><?= ArrayHelper::getValue($st, 'type') ?>: <?= ArrayHelper::getValue($st, 'present'); ?>/<?= ArrayHelper::getValue($st, 'reserved'); ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        <?php endforeach; ?>
    </div>
    <?php $this->endCache(); ?>
<?php endif; ?>
