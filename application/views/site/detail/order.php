<?php

use app\models\tool\seo\Title;
use app\models\tool\Currency;
use app\models\tool\Price;
use yii\helpers\Html;
use app\models\helpers\OrderHelper;

/* @var $order \app\modules\order\models\entity\Order */

$this->title = Title::showTitle("Заказ №" . $order->id);
$this->params['breadcrumbs'][] = ['label' => 'Список заказов', 'url' => ['/order/']];
$this->params['breadcrumbs'][] = ['label' => 'Заказ №' . $order->id, 'url' => ['/order/' . $order->id . '/']];
?>
<section class="detail-order">
    <div class="detail-order-info-wrap">
        <h1 class="detail-order-info__title"><?= "Заказ №" . $order->id; ?></h1>
        <div class="detail-order">
            <div class="detail-order__sidebar">
                <ul class="detail-info">
                    <li class="detail-info__item">
                        <div class="detail-info__title">Дата заказа</div>
                        <div class="detail-info__value"><?= date('d.m.Y h:i:s', $order->created_at); ?></div>
                    </li>
                    <li class="detail-info__item">
                        <div class="detail-info__title">Сумма заказа</div>
                        <div class="detail-info__value"><?= Price::format(OrderHelper::orderSummary($order->id)); ?> <?= Currency::getInstance()->show(); ?></div>
                    </li>
                    <li class="detail-info__item">
                        <div class="detail-info__title">Статус</div>
                        <div class="detail-info__value"><?= OrderHelper::getStatus($order); ?></div>
                    </li>
                    <li class="detail-info__item">
                        <div class="detail-info__title">Оплата</div>
                        <div class="detail-info__value"><?= ($order->is_paid ? '<span class="green">Оплачено</span>' : '<span class="red">Не оплачено</span>'); ?></div>
                    </li>
                    <?php if ($order->is_cancel): ?>
                        <li class="detail-info__item">
                            <div class="detail-info__title">Отмена</div>
                            <div class="detail-info__value">Заказ отменён</div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="detail-order__main">
                <ul class="product-order-detail">
                    <?php foreach ($items as $item): ?>
                        <li class="product-order-detail__item">
                            <img class="product-order-detail__image" src="<?= ($item->product ? "/upload/{$item->product->image}" : "/upload/images/not-image.png"); ?>">
                            <div class="product-order-detail__title">
                                <?php if ($item->product instanceof \app\models\entity\Product): ?>
                                    <a class="product-order-detail__link" href="<?= $item->product->detail; ?>"><?= $item->name; ?></a>
                                <?php else: ?>
                                    <a class="product-order-detail__link" href="javascript:void(0);"><?= $item->name; ?></a>
                                <?php endif; ?>
                            </div>
                            <div class="product-order-detail__price">Цена за ед.: <?= $item->price; ?> <?= Currency::getInstance()->show(); ?></div>
                            <div class="product-order-detail__count">Кол-во: <?= $item->count; ?></div>
                            <div class="product-order-detail__summary">Итого: <?= $item->count * $item->price; ?> <?= Currency::getInstance()->show(); ?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
</section>
