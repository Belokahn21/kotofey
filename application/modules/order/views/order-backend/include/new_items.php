<?php
/* @var $itemsModel \app\modules\order\models\entity\OrdersItems */
?>
<?php for ($i = 0; $i < 6; $i++): ?>
    <div class="row orders-items-item">
        <div class="col-sm-4">
            <?= $form->field($itemsModel, '[' . $i . ']name')->textInput(['class' => 'load-product-info__name form-control']); ?>
        </div>
        <div class="col-sm-1">
            <?= $form->field($itemsModel, '[' . $i . ']count')->textInput(['class' => 'load-product-info__count form-control']); ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($itemsModel, '[' . $i . ']purchase')->textInput(['class' => 'load-product-info__purchase form-control']); ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($itemsModel, '[' . $i . ']price')->textInput(['class' => 'load-product-info__price form-control']); ?>
        </div>
        <div class="col-sm-1">
            <?= $form->field($itemsModel, '[' . $i . ']product_id')->textInput(['class' => 'load-product-info__pid form-control']); ?>
        </div>
        <div class="col-sm-1">
            <?= $form->field($itemsModel, '[' . $i . ']need_delete')->checkbox(); ?>
        </div>
    </div>
<?php endfor; ?>