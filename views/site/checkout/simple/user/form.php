<?php

use yii\helpers\ArrayHelper;
use app\models\entity\user\Billing;

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
        Дата доставки
    </div>
    <div class="row">
        <div class="col-sm-12">
            <input type="text" class="js-datepicker checkout__input">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <ul class="order-time">
                <li class="order-time__item">с 12.00 до 13.00</li>
                <li class="order-time__item">с 12.00 до 13.00</li>
                <li class="order-time__item">с 12.00 до 13.00</li>
                <li class="order-time__item">с 12.00 до 13.00</li>
                <li class="order-time__item">с 12.00 до 13.00</li>
            </ul>
        </div>
    </div>
</div>


<div class="checkout-block">
    <div class="checkout-block__title">
        Информация о заказе
    </div>
    <div class="row">
        <div class="col-sm-12">
			<?= $form->field($order, 'select_billing')->dropDownList(ArrayHelper::map(Billing::find()->where(['user_id' => Yii::$app->user->id])->all(), 'id', 'test'), ['prompt' => 'Указать адрес доставки'])->label(false); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
			<?= $form->field($order, 'comment')->textarea(['class' => 'checkout__textarea', 'placeholder' => 'Комментарий к заказу'])->label(false); ?>
        </div>
    </div>
</div>