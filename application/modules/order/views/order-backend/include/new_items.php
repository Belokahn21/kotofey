<?php
/* @var $itemsModel \app\modules\order\models\entity\OrdersItems
 * @var $form \yii\widgets\ActiveForm
 */

use yii\helpers\Html;
use app\modules\order\widgets\FindProductsWidgets\FindProducstWidgets;

?>
<?php for ($i = 0; $i < 6; $i++): ?>
    <div class="row orders-items-item">
        <div class="col-sm-3">
            <?= $form->field($itemsModel, '[' . $i . ']name')->textInput(['class' => 'load-product-info__name form-control', 'placeholder' => "Наименование"])->label(false); ?>
        </div>
        <div class="col-sm-1">
            <?= $form->field($itemsModel, '[' . $i . ']count')->textInput(['class' => 'load-product-info__count form-control', 'placeholder' => "Количество"])->label(false); ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($itemsModel, '[' . $i . ']purchase')->textInput(['class' => 'load-product-info__purchase form-control', 'placeholder' => "Закупочная"])->label(false); ?>
        </div>
        <div class="col-sm-1">
            <?= $form->field($itemsModel, '[' . $i . ']price')->textInput(['class' => 'load-product-info__price form-control', 'placeholder' => "Цена"])->label(false); ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($itemsModel, '[' . $i . ']discount_price')->textInput(['class' => 'load-product-info__discount_price form-control', 'placeholder' => "Со скидкой"])->label(false); ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($itemsModel, '[' . $i . ']product_id')->widget(FindProducstWidgets::className(), ['placeholder' => 'ID товара'])->label(false); ?>
        </div>
        <div class="col-sm-1">
            <label class="skip-icon">
                <?= Html::activeCheckbox($itemsModel, '[' . $i . ']need_delete', [
                    'label' => false,
                ]); ?>
                <i class="far fa-times-circle"></i>
            </label>
        </div>
    </div>
<?php endfor; ?>