<?php

use app\models\entity\OrderStatus;
use app\models\entity\OrdersItems;
use app\models\entity\Payment;
use app\models\entity\Delivery;
use yii\helpers\Html;
use app\models\tool\seo\Title;
use app\models\entity\User;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\tool\Price;
use app\models\tool\Currency;
use app\models\helpers\OrderHelper;

/* @var $model \app\models\entity\Order */

$this->title = Title::showTitle("Заказ №" . $model->id); ?>
<section class="new-order-block">
<?php $form = ActiveForm::begin(); ?>
    <div class="left-col">
        <h1 class="title">Заказ №<?= $model->id; ?></h1>
        <br/>
        <?= Html::a("Назад", '/admin/order/', ['class' => 'btn-main']) ?>
        <h3 class="title">Информация о заказе</h3>
        <div style="margin: 1% 0; color: green; font-weight: bold; border: 1px #e2e2e2 solid; display: inline-block; padding: 1%; -webkit-border-radius: 0.2em;-moz-border-radius: 0.2em;border-radius: 0.2em;">Сумма заказа: <?= Price::format(OrderHelper::orderSummary($model->id)); ?><?= (new Currency())->show(); ?></div>
        <div class="new-order-info">
            <?= $form->field($model, 'status')->dropDownList(ArrayHelper::map(OrderStatus::find()->all(), 'id', 'name'), ['prompt' => 'Статус заказа']); ?>
            <?= $form->field($model, 'payment_id')->dropDownList(ArrayHelper::map(Payment::find()->all(), 'id', 'name'), ['prompt' => 'Способ оплаты']); ?>
            <?= $form->field($model, 'delivery_id')->dropDownList(ArrayHelper::map(Delivery::find()->all(), 'id', 'name'), ['prompt' => 'Способ доставки']); ?>
        </div>
        <?= $form->field($model, 'is_paid')->radioList(array("Не оплачено", "Оплачено")); ?>
        <?= $form->field($model, 'comment')->textarea(); ?>
        <h3 class="title">Покупатель</h3>
        <?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map(User::find()->all(), 'id', 'email'), ['prompt' => 'Покупатель']); ?>

    </div>
    <div class="right-col">
        <h3 class="title">Товары в заказе</h3>
        <ul class="order-list-item">
            <li class="list-item header">
                <div class="list-item__name">название</div>
                <div class="list-item__price">цена</div>
                <div class="list-item__count">количество</div>
                <div class="list-item__total">итого</div>
            </li>
            <?php /* @var $item OrdersItems */ ?>
            <?php foreach ($items as $item): ?>
                <li class="list-item">
                    <div class="list-item__name">
                        <?php if ($item->product_id): ?>
                            <?= Html::a($item->product->name, '/admin/catalog/' . $item->product->id . '/'); ?>
                        <?php else: ?>
                            <?= $item->name; ?>
                        <?php endif; ?>
                    </div>
                    <div class="list-item__price"><?= $item->price; ?></div>
                    <div class="list-item__count"><?= $item->count; ?></div>
                    <div class="list-item__total"><?= $item->count * $item->price; ?></div>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php // $model->product_id = ArrayHelper::getColumn(OrdersItems::find()->select('product_id')->where(['order_id' => $model->id])->all(), 'product_id'); ?>
        <?php //$form->field($model, 'product_id')->widget('\app\widgets\SelectProductDropdown')->label(false) ?>
    </div>
    <div class="clearfix"></div>
    <?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>
</section>