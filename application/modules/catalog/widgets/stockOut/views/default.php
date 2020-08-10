<?php

/* @var $products \app\modules\catalog\models\entity\Product[] */

use yii\helpers\Html;
use app\modules\catalog\models\helpers\ProductHelper;
use app\models\tool\Price;
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
                            <ul class="stock-out-info">
                                <li class="stock-out-info__row">
                                    <div class="stock-out-info__key">Количество</div>
                                    <div class="stock-out-info__value"><?= $product->count; ?></div>
                                </li>
                                <li class="stock-out-info__row">
                                    <div class="stock-out-info__key">Закуплено на сумму</div>
                                    <div class="stock-out-info__value"><?= $product->count * $product->purchase; ?></div>
                                </li>
                                <li class="stock-out-info__row">
                                    <div class="stock-out-info__key">Доход</div>
                                    <div class="stock-out-info__value"><?= $product->count * ($product->price - $product->purchase); ?></div>
                                </li>
                            </ul>
                            <a href="<?= Url::to(['/catalog/product-backend/update', 'id' => $product->id]); ?>">
                                <img class="stock-out__image" src="/upload/<?= $product->image; ?>"
                                     title="<?= $product->name; ?>" alt="<?= $product->name; ?>">
                            </a>
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