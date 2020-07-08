<?php

/* @var $products \app\modules\catalog\models\entity\Product[] */

use yii\helpers\Html;
use app\modules\catalog\models\helpers\ProductHelper;
use app\models\tool\Price;

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
                <ul class="stack-out">
					<?php foreach ($products as $product): ?>
                        <li class="stack-out__item">
                            <ul class="stack-out-info">
                                <li class="stack-out-info__row">
                                    <div class="stack-out-info__key">Количество</div>
                                    <div class="stack-out-info__value"><?= $product->count; ?></div>
                                </li>
                                <li class="stack-out-info__row">
                                    <div class="stack-out-info__key">Закуплено на сумму</div>
                                    <div class="stack-out-info__value"><?= $product->count * $product->purchase; ?></div>
                                </li>
                                <li class="stack-out-info__row">
                                    <div class="stack-out-info__key">Доход</div>
                                    <div class="stack-out-info__value"><?= $product->count * ($product->price - $product->purchase); ?></div>
                                </li>
                            </ul>
                            <img class="stack-out__image" src="/upload/<?= $product->image; ?>">
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