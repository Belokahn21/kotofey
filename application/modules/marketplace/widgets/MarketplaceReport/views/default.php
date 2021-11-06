<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\marketplace\models\services\MarketplaceService;

?>
Список товаров площадки
<?php
$ms = new MarketplaceService();
?>
<div class="marketplace-products">
    <?php $ozon_stocks = $ms->countStock(); ?>
    <?php foreach ($ms->getProducts() as $ozon_element) : ?>
        <?php $product = Product::findOne(['article' => ArrayHelper::getValue($ozon_element, 'offer_id')]); ?>
        <?php $product_ozon_stock = false; ?>
        <?php foreach ($ozon_stocks as $item) : ?>
            <?php if ($item['offer_id'] == $product->article) $product_ozon_stock = $item; ?>
        <?php endforeach; ?>

        <?php $status = ''; ?>
        <?php foreach (ArrayHelper::getValue($product_ozon_stock, 'stocks') as $st): ?>
            <?php if ((intval(ArrayHelper::getValue($st, 'present')) == $product->count) && $product->count > 0) $status = 'good'; ?>
            <?php if ((intval(ArrayHelper::getValue($st, 'present')) > $product->count) && $product->count > 0) $status = 'warning'; ?>
            <?php if ((intval(ArrayHelper::getValue($st, 'present')) < $product->count) && $product->count > 0) $status = 'can'; ?>
        <?php endforeach; ?>

        <div class="marketplace-products-item-wrap">
            <div class="marketplace-products-item <?= $status; ?>">
                <div class="marketplace-products-item-image-wrap">
                    <?= Html::img(ProductHelper::getImageUrl($product), ['class' => 'marketplace-products-item-image']); ?>
                </div>
                <a href="<?= Url::to(['/admin/catalog/product-backend/update', 'id' => $product->id]); ?>" target="_blank" class="marketplace-products-item__name"><?= $product->name; ?></a>
                <div class="marketplace-products-item__stock marketplace">
                    <div>Склад: <?= $product->count; ?></div>
                    <?php foreach (ArrayHelper::getValue($product_ozon_stock, 'stocks') as $st): ?>
                        <div><?= ArrayHelper::getValue($st, 'type') ?>: <?= ArrayHelper::getValue($st, 'present'); ?>/<?= ArrayHelper::getValue($st, 'reserved'); ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>