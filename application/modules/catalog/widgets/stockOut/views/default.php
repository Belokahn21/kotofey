<?php

/* @var $products \app\modules\catalog\models\entity\Product[] */

use yii\helpers\Html;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\site\models\tools\Price;
use yii\helpers\Url;

///admin/catalog/product-backend/update
?>
<?= Html::a('Остатки', "javascript:void(0);", ['data-target' => '#stockOut', 'data-toggle' => 'modal', 'class' => 'btn-main']); ?>

<div class="modal fade" id="stockOut" tabindex="-1" role="dialog" aria-labelledby="stockOutTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stockOutTitle">
                    <div>Складской учёт</div>
                    <div>Закуп: <?= Price::format(ProductHelper::purchaseVirtual($products)); ?></div>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="stock-out">
                    <?php foreach ($products as $product): ?>
                        <li class="stock-out__item">
                            <div class="stock-out__name">
                                <a href="<?= Url::to(['/catalog/product-backend/update', 'id' => $product->id]); ?>"><?= $product->name; ?></a>
                            </div>
                            <a href="<?= Url::to(['/catalog/product-backend/update', 'id' => $product->id]); ?>">
                                <img class="stock-out__image" src="<?= ProductHelper::getImageUrl($product); ?>" title="<?= $product->name; ?>" alt="<?= $product->name; ?>">
                            </a>
                            <div class="stock-out__price">Цена: <?= $product->price; ?></div>
                            <div class="stock-out__count">Количество: <?= $product->count; ?></div>
                            <div class="stock-out__purchase">Закупочная:<?= $product->purchase; ?></div>
                            <div class="stock-out__summary">Доход:<?= ($product->price - $product->purchase) * $product->count; ?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>