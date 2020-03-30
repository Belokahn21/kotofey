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
    <h1 class="title">Заказ №<?= $model->id; ?></h1>
    <?= Html::a("Назад", ['admin/order'], ['class' => 'btn-main']) ?>
    <div style="margin: 1% 0; color: green; font-weight: bold; border: 1px #e2e2e2 solid; display: inline-block; padding: 1%; -webkit-border-radius: 0.2em;-moz-border-radius: 0.2em;border-radius: 0.2em;">Сумма заказа: <?= Price::format(OrderHelper::orderSummary($model->id)); ?><?= Currency::getInstance()->show(); ?></div>
    <div style="margin: 1% 0; color: green; font-weight: bold; border: 1px #e2e2e2 solid; display: inline-block; padding: 1%; -webkit-border-radius: 0.2em;-moz-border-radius: 0.2em;border-radius: 0.2em;">Итого к оплате: <?= Price::format(OrderHelper::orderSummary($model->id)); ?><?= Currency::getInstance()->show(); ?></div>
    <?= $this->render('../_forms/_order', [
        'form' => $form,
        'model' => $model,
        'items' => $items,
        'itemModel' => $itemModel,
    ]); ?>
    <?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
    <?php ActiveForm::end(); ?>
</section>