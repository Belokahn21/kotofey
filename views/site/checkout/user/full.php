<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\widgets\promoCart\promoCartWidget;

/* @var $promo_model \app\models\entity\Promo */
/* @var $order \app\models\entity\Order */
/* @var $billing \app\models\entity\user\Billing */
?>
<?= promoCartWidget::widget(); ?>
<?php $form = ActiveForm::begin(); ?>
<!--<div class="order-type-form__title">Промокод</div>-->
<!--<div class="order-type-form__element">-->
<?php //= $form->field($promo_model, 'code')->textInput(['placeholder' => 'Промокод'])->label(false); ?>
<!--</div>-->
<!--<div class="order-type-form__promo">-->
<!--    <span>Промокод: zoocat</span>-->
<!--    <span>Скидка: 10%</span>-->
<!--</div>-->
<div class="order-type-form__title">Информация о заказе</div>
<div class="order-type-form__element">
    <?= $form->field($order, 'delivery_id')->dropDownList(ArrayHelper::map($delivery, 'id', 'name'), ['prompt' => 'Вариант доставки'])->label(false) ?>
</div>
<div class="order-type-form__element">
    <?= $form->field($order, 'payment_id')->dropDownList(ArrayHelper::map($payment, 'id', 'name'), ['prompt' => 'Вариант оплаты'])->label(false) ?>
</div>
<div class="order-type-form__element">
    <?= $form->field($order, 'comment')->textarea(['placeholder' => 'Комментарий к заказу']) ?>
</div>
<div class="order-type-form__element">
    <?= $form->field($billing, 'city')->textInput(['placeholder' => 'Город'])->label(false); ?>
</div>
<div class="order-type-form__element">
    <?= $form->field($billing, 'street')->textInput(['placeholder' => 'Улица'])->label(false); ?>
</div>
<div class="order-type-form__element">
    <?= $form->field($billing, 'home')->textInput(['placeholder' => 'Номер дома'])->label(false); ?>
</div>
<div class="order-type-form__element">
    <?= $form->field($billing, 'house')->textInput(['placeholder' => 'Квартира'])->label(false); ?>
</div>
<?= Html::submitButton('Купить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>
