<?php

use app\models\tool\Price;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\catalog\models\helpers\ProductHelper;

/* @var $order_items \app\modules\order\models\entity\OrdersItems[]
 * @var $order \app\modules\order\models\entity\Order
 */
?>
<div style="width: 100%; height: 500px;">
    <div style="padding: 10px; width: 100%; text-align: center;  background: #2d0c03; color: white; font-weight: bold; text-transform: uppercase;">
        Спасибо за покупку!
    </div>
    <div style="display: flex; flex-direction: row; justify-content: space-between; margin: 10px;">
        <div style="width: 50%; text-align: center;">
            <h2>Информация о заказе</h2>
            <ul style="list-style: none; display: block; max-width: 290px;">
                <li style="width: 100%; margin: 0; padding: 0; display: flex;flex-direction: row; justify-content: stretch; border-bottom: 1px #e3e3e3 solid; ">
                    <div style="min-width: 120px; padding: 5px; text-align: right;">Дата заказа</div>
                    <div style="min-width: 170px; padding: 5px; text-align: left;"><?= date('d.m.Y', $order->created_at); ?></div>
                </li>
                <li style="width: 100%; margin: 0; padding: 0; display: flex;flex-direction: row; justify-content: stretch; border-bottom: 1px #e3e3e3 solid; ">
                    <div style="min-width: 120px; padding: 5px; text-align: right;">Статус заказа</div>
                    <div style="min-width: 170px; padding: 5px; text-align: left;"><?= OrderHelper::getStatus($order); ?></div>
                </li>
                <li style="width: 100%; margin: 0; padding: 0; display: flex;flex-direction: row; justify-content: stretch; border-bottom: 1px #e3e3e3 solid; ">
                    <div style="min-width: 120px; padding: 5px; text-align: right;">Доставка</div>
                    <div style="min-width: 170px; padding: 5px; text-align: left;"><?= OrderHelper::getDelivery($order); ?></div>
                </li>
                <li style="width: 100%; margin: 0; padding: 0; display: flex;flex-direction: row; justify-content: stretch; border-bottom: 1px #e3e3e3 solid; ">
                    <div style="min-width: 120px; padding: 5px; text-align: right;">Оплата</div>
                    <div style="min-width: 170px; padding: 5px; text-align: left;"><?= OrderHelper::getPayment($order); ?></div>
                </li>
            </ul>
            <h2>Чек</h2>
            <ul style="list-style: none; width: 100%; display: block;">
                <?php $out_summ = 0; ?>
                <?php foreach ($order_items as $item): ?>
                    <li style="width: 100%; margin: 5px; display: flex; flex-direction: row;">
                        <div style="text-align: center;width: 75%; padding: 5px;">
                            <?= $item->name; ?>
                        </div>
                        <div style="text-align: center;width: 12.5%; padding: 5px;">
                            <?= $item->count; ?> шт
                        </div>
                        <div style="text-align: center;width: 12.5%; padding: 5px;">
                            <?= $item->price; ?> р.
                        </div>
                    </li>
                    <?php $out_summ += $item->count * $item->price; ?>
                <?php endforeach; ?>
                <li style="width: 100%; margin: 5px; display: flex; flex-direction: row; border-top: 1px solid #e3e3e3;">
                    <div style="width: 85%; text-align:right;padding: 5px;">
                        Итого:
                    </div>
                    <div style="text-align: center;width: 15%; padding: 5px;">
                        <?= Price::format(OrderHelper::orderSummary($order)); ?> р.
                    </div>
                </li>
            </ul>
        </div>
        <div style="width: 50%; text-align: center;">
            <h2>Товары в заказе</h2>
            <ul style="list-style: none; display: flex; flex-direction: row;">
                <?php foreach ($order_items as $item): ?>
                    <?php if ($item->product_id > 0): ?>
                        <li style="width: 25%; margin: 5px;">
                            <img src="<?= ProductHelper::getImageUrl($item->product, true) ?>" style="width: 100%;">
                            <div style="text-align: center;">
                                <?= $item->name; ?>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div style="padding: 10px; width: 100%; margin: 35px 0 0 0; text-align: center;  background: #2d0c03; color: white; font-weight: bold; text-transform: uppercase;">
        Интернет-зоомагазин Котофей
    </div>
</div>