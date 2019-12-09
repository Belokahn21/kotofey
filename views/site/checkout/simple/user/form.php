<?php

use yii\helpers\ArrayHelper;

/* @var $this \yii\web\View */
/* @var $discount_model \app\models\forms\DiscountForm */
/* @var $user \app\models\entity\User */
/* @var $delivery \app\models\entity\Delivery[] */
/* @var $payment \app\models\entity\Payment[] */
/* @var $order \app\models\entity\Order */
/* @var $billing \app\models\entity\user\Billing */

?>

<?= $this->render('../bonus', [
	'form' => $form,
	'DiscountModel' => $discount_model
]); ?>

<div class="checkout-block">
    <div class="checkout-block__title">
        Покупатель
    </div>
    <ul class="checkout-user-reqs">
        <li class="user-reqs__item">
            <div class="user-reqs__item__key">Телефон</div>
            <div class="user-reqs__item__value phone_mask"><?= \Yii::$app->user->identity->phone; ?></div>
        </li>
        <li class="user-reqs__item">
            <div class="user-reqs__item__key">Email</div>
            <div class="user-reqs__item__value"><?= \Yii::$app->user->identity->email; ?></div>
        </li>
    </ul>
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
            <textarea class="checkout__textarea" placeholder="Комментарий к заказу"></textarea>
        </div>
    </div>
</div>