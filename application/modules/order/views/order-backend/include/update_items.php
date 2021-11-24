<?php

use yii\helpers\Html;
use app\modules\order\widgets\FindProductsWidgets\FindProducstWidgets;

/* @var $itemsModel \app\modules\order\models\entity\OrdersItems
 * @var $form \yii\widgets\ActiveForm
 */

$iter = 0;
$model = new \app\modules\order\models\entity\OrdersItems();
?>
<?php foreach ($itemsModel as $i => $item): ?>
    <div class="row orders-items-item">
        <div class="col-sm-3">
            <?= $form->field($item, '[' . $i . ']name')->textInput(['class' => 'load-product-info__name form-control', 'placeholder' => "Наименование"])->label(false); ?>
        </div>
        <div class="col-sm-1">
            <?= $form->field($item, '[' . $i . ']count')->textInput(['class' => 'load-product-info__count form-control', 'placeholder' => "Количество"])->label(false); ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($item, '[' . $i . ']purchase')->textInput(['class' => 'load-product-info__purchase form-control', 'placeholder' => "Закупочная"])->label(false); ?>
        </div>
        <div class="col-sm-1">
            <?= $form->field($item, '[' . $i . ']price')->textInput(['class' => 'load-product-info__price form-control', 'placeholder' => "Цена"])->label(false); ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($item, '[' . $i . ']discount_price')->textInput(['class' => 'load-product-info__discount_price form-control', 'placeholder' => "Со скидкой"])->label(false); ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($item, '[' . $i . ']product_id')->widget(FindProducstWidgets::className(), ['placeholder' => 'ID товара'])->label(false); ?>
        </div>
        <div class="col-sm-1">
            <label class="skip-icon">
                <?= Html::activeCheckbox($item, '[' . $i . ']need_delete', [
                    'label' => false,
                ]); ?>
                <i class="far fa-times-circle"></i>
            </label>
        </div>
    </div>
    <?php $iter++; ?>
<?php endforeach; ?>
<?php for ($j = $iter; $j < $iter + 3; $j++): ?>
    <div class="row orders-items-item">
        <div class="col-sm-3">
            <?= $form->field($model, '[' . $j . ']name')->textInput(['class' => 'load-product-info__name form-control', 'placeholder' => "Наименование"])->label(false); ?>
        </div>
        <div class="col-sm-1">
            <?= $form->field($model, '[' . $j . ']count')->textInput(['class' => 'load-product-info__count form-control', 'placeholder' => "Количество"])->label(false); ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, '[' . $j . ']purchase')->textInput(['class' => 'load-product-info__purchase form-control', 'placeholder' => "Закупочная"])->label(false); ?>
        </div>
        <div class="col-sm-1">
            <?= $form->field($model, '[' . $j . ']price')->textInput(['class' => 'load-product-info__price form-control', 'placeholder' => "Цена"])->label(false); ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, '[' . $j . ']discount_price')->textInput(['class' => 'load-product-info__discount_price form-control', 'placeholder' => "Со скидкой"])->label(false); ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, '[' . $j . ']product_id')->widget(FindProducstWidgets::className())->label(false); ?>
        </div>
        <div class="col-sm-1">
            <label class="skip-icon">
                <?= Html::activeCheckbox($model, '[' . $i . ']need_delete', [
                    'label' => false,
                ]); ?>
                <i class="far fa-times-circle"></i>
            </label>
        </div>
    </div>
<?php endfor; ?>
