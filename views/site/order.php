<?php

use app\models\entity\OrdersItems;
use yii\helpers\Html;
use app\models\tool\Price;
use app\models\tool\seo\Title;
use app\models\tool\Currency;
use app\models\helpers\OrderHelper;

$currency = new Currency();

/* @var $orders \app\modules\order\models\entity\Order[] */
/* @var $items \app\models\entity\OrdersItems[] */
/* @var $item \app\models\entity\OrdersItems */
?>
<?php $this->title = Title::showTitle("Список заказов");
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['/profile/']];
$this->params['breadcrumbs'][] = ['label' => 'Список заказов', 'url' => ['/order/']]; ?>
<section class="list-orders">
    <h1>Список заказов</h1>
    <?php if ($orders): ?>
        <ul class="orders">
            <?php foreach ($orders as $order): ?>
                <li class="orders__item">
                    <div class="orders__header">
                        <div class="orders__number">
                            <span>Заказ №<?= $order->id; ?></span>
                        </div>
                        <div class="order-info-wrap">
                            <ul class="order-info">
                                <li class="order-info__item">
                                    <div class="order-info__item-key">Дата покупки</div>
                                    <div class="order-info__item-value"><?= date('d.m.Y', $order->created_at); ?></div>
                                </li>
                                <li class="order-info__item">
                                    <div class="order-info__item-key">Статус</div>
                                    <div class="order-info__item-value"><?= OrderHelper::getStatus($order); ?></div>
                                </li>
                                <li class="order-info__item">
                                    <div class="order-info__item-key">Оплата</div>
                                    <div class="order-info__item-value">
                                        <?php if ($order->is_paid): ?>
                                            <span class="green">Оплачено</span>
                                        <?php else: ?>
                                            Не оплачено
                                        <?php endif; ?>
                                    </div>
                                </li>
                                <li class="order-info__item">
                                    <div class="order-info__item-key">Сумма заказа</div>
                                    <div class="order-info__item-value"><?= Price::format(OrderHelper::orderSummary($order->id)); ?> <?= Currency::getInstance()->show(); ?></div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="orders__content">
                        <ul class="orders-items">
                            <?php foreach (OrdersItems::findAll(['order_id' => $order->id]) as $item): ?>
                                <li class="orders-items__item">
                                    <div class="orders-items__image-wrap">
                                        <?php if ($item->product): ?>
                                            <img src="/upload/<?= $item->product->image; ?>" class="orders-items__image">
                                        <?php endif; ?>
                                    </div>
                                    <div class="orders-items-info">
                                        <div class="orders-items-info__title"><?= $item->name; ?></div>
                                        <div class="row d-flex justify-content-between">
                                            <div class="col-sm-4"><?= $item->count; ?> шт</div>
                                            <div class="col-sm-4"><?= Price::format($item->price); ?> р</div>
                                            <div class="col-sm-4"><?= Price::format($item->count * $item->price); ?> р</div>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        Вы ничего не покупали
    <?php endif; ?>
</section>
