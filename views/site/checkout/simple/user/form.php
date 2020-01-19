<?php

use yii\helpers\ArrayHelper;
use app\models\entity\user\Billing;

/* @var $this \yii\web\View
 * @var $discount_model \app\models\forms\DiscountForm
 * @var $user \app\models\entity\User
 * @var $delivery \app\models\entity\Delivery[]
 * @var $payment \app\models\entity\Payment[]
 * @var $order \app\models\entity\Order
 * @var $billing \app\models\entity\user\Billing
 * @var $order_date \app\models\entity\OrderDate
 * @var $delivery_time \app\models\services\DeliveryTimeService
 */

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
        <div class="col-sm-12 select-day">
            <?= $form->field($order_date, 'date')->textInput(['class' => 'js-datepicker checkout__input', 'value' => $delivery_time->getAvailableDate(), 'placeholder' => 'Указать день доставки'])->label(false); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="order-time-wrap">
                <ul class="order-time">
                    <?php foreach ($delivery_time->getTimeList() as $key => $time): ?>
                        <li data-value="с <?= $key; ?>.00 до <?= $time; ?>.00" class="order-time__item">с <?= $key; ?>.00 до <?= $time; ?>.00</li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?= $form->field($order_date, 'time')->hiddenInput(['class' => 'order-time-input'])->label(false); ?>
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