<?php

use yii\helpers\ArrayHelper;

/* @var $this \yii\web\View */
/* @var $discount_model \app\models\forms\DiscountForm */
/* @var $user \app\models\entity\User */
/* @var $delivery \app\models\entity\Delivery[] */
/* @var $payment \app\models\entity\Payment[] */
/* @var $order \app\models\entity\Order */
/* @var $billing \app\models\entity\user\Billing */
/* @var $delivery_time \app\models\services\DeliveryTimeService */

?>

<?= $this->render('../bonus', [
	'form' => $form,
	'DiscountModel' => $discount_model
]); ?>

<div class="checkout-block">
    <div class="checkout-block__title">
        Покупатель
    </div>
    <div class="row">
        <div class="col-sm-4">
			<?= $form->field($user, 'email', ['enableAjaxValidation' => true])->textInput(['class' => 'checkout__input', 'placeholder' => 'Email'])->label(false); ?>
        </div>
        <div class="col-sm-4">
			<?= $form->field($user, 'phone', ['enableAjaxValidation' => true])->textInput(['class' => 'checkout__input', 'placeholder' => 'Телефон'])->label(false); ?>
        </div>
        <div class="col-sm-4">
			<?= $form->field($user, 'password')->passwordInput(['class' => 'checkout__input', 'placeholder' => 'Пароль'])->label(false); ?>
        </div>
    </div>
</div>


<div class="checkout-block">
    <div class="checkout-block__title">
        Доставка и оплата
    </div>
    <div class="row">
        <div class="col-sm-6">
			<?= $form->field($order, 'delivery_id')->dropDownList(ArrayHelper::map($delivery, 'id', 'name'), ['prompt' => 'Вариант доставки'])->label(false); ?>
        </div>
        <div class="col-sm-6">
			<?= $form->field($order, 'payment_id')->dropDownList(ArrayHelper::map($payment, 'id', 'name'), ['prompt' => 'Вариант оплаты'])->label(false); ?>
        </div>
    </div>
</div>


<div class="checkout-block">
    <div class="checkout-block__title">
        Информация о заказе
    </div>
    <div class="row">
        <div class="col-sm-3">
			<?= $form->field($billing, 'city')->textInput(['class' => 'checkout__input', 'placeholder' => 'Город'])->label(false); ?>
        </div>
        <div class="col-sm-3">
			<?= $form->field($billing, 'street')->textInput(['class' => 'checkout__input', 'placeholder' => 'Улица'])->label(false); ?>
        </div>
        <div class="col-sm-3">
			<?= $form->field($billing, 'home')->textInput(['class' => 'checkout__input', 'placeholder' => 'Дом'])->label(false); ?>
        </div>
        <div class="col-sm-3">
			<?= $form->field($billing, 'house')->textInput(['class' => 'checkout__input', 'placeholder' => 'Квартира'])->label(false); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
			<?= $form->field($order, 'comment')->textarea(['class' => 'checkout__textarea', 'placeholder' => 'Комментарий к заказу'])->label(false); ?>
        </div>
    </div>
</div>