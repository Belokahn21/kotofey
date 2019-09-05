<?

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $model \app\widgets\order_custom_product\models\OrderCustomProductForm */

?>
<div class="custom-order-wrap">
    <div class="select-type-order">
        <div class="select-type-order-construct">Выбрать из предложенного</div>
        <div class="select-type-order-custom">Свой вариант</div>
    </div>

    <div class="custom-order-form-wrap">
        <? $form = ActiveForm::begin(); ?>

        <div class="custom-order-form-contact">
            <?= $form->field($model, 'email')->textInput() ?>
            <?= $form->field($model, 'phone')->textInput() ?>
        </div>

        <div class="custom-order-elems">
            <?= $form->field($model, 'type')->dropDownList(array("Портоне", "Кошелек"), ['prompt' => 'Предмет']); ?>
            <?= $form->field($model, 'leather_type')->dropDownList(array("Crazy Horse", "КРС"), ['prompt' => 'Тип кожи']); ?>
            <?= $form->field($model, 'color')->dropDownList(array("Красный", "Черный", "Белый", "Синий"), ['prompt' => 'Цвет изделия']); ?>
        </div>

        <div class="custom-order-elems">
            <?= $form->field($model, 'description')->textarea()->label("Опишите товар своими словами, который выхотите заказать. Укажите все нюансы, которые нужно учесть"); ?>
        </div>

        <?=Html::submitButton('Отправить заявку', ['class'=>'btn-main'])?>
        <? ActiveForm::end(); ?>
    </div>
</div>
