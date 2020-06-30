<?php

/* @var $products \app\modules\catalog\models\entity\Product[] */

use yii\helpers\Html;

?>
<?= Html::a('Остатки', "javascript:void(0);", ['data-target' => '#stockOut', 'data-toggle' => 'modal', 'class' => 'btn-main']); ?>

<div class="modal fade" id="stockOut" tabindex="-1" role="dialog" aria-labelledby="stockOutTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stockOutTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul>
					<?php foreach ($products as $product): ?>
                        <li style="margin-bottom: 5px;">(В наличии <?= $product->count; ?>) - <?= Html::a($product->name, \yii\helpers\Url::to(['/admin/catalog/product-backend/update', 'id' => $product->id])) ?></li>
					<?php endforeach; ?>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>