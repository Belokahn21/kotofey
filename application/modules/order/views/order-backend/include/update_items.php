<?php
/* @var $itemsModel \app\modules\order\models\entity\OrdersItems */
$iter = 0;
$model = new \app\modules\order\models\entity\OrdersItems();
?>
<?php foreach ($itemsModel as $i => $item): ?>
    <div class="row orders-items-item">
        <div class="col-sm-3">
            <?= $form->field($item, '[' . $i . ']name')->textInput(['class' => 'load-product-info__name form-control']); ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($item, '[' . $i . ']count')->textInput(['class' => 'load-product-info__count form-control']); ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($item, '[' . $i . ']price')->textInput(['class' => 'load-product-info__price form-control']); ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($item, '[' . $i . ']product_id')->textInput(['class' => 'load-product-info form-control']); ?>
        </div>
        <div class="col-sm-1">
            <?= $form->field($item, '[' . $i . ']need_delete')->checkbox(); ?>
        </div>
    </div>
    <?php $iter++; ?>
<?php endforeach; ?>
<?php for ($j = $iter; $j < $iter + 3; $j++): ?>
    <div class="row orders-items-item">
        <div class="col-sm-3">
            <?= $form->field($model, '[' . $j . ']name')->textInput(['class' => 'load-product-info__name form-control']); ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, '[' . $j . ']count')->textInput(['class' => 'load-product-info__count form-control']); ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, '[' . $j . ']price')->textInput(['class' => 'load-product-info__price form-control']); ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, '[' . $j . ']product_id')->textInput(['class' => 'load-product-info form-control']); ?>
        </div>
        <div class="col-sm-1">
            <?= $form->field($model, '[' . $j . ']need_delete')->checkbox(); ?>
        </div>
    </div>
<?php endfor; ?>
