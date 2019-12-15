<?php
/* @var $order_items \app\models\entity\OrdersItems[] */
?>
<div style="width: 100%; height: 500px;">
    <div style="padding: 10px; width: 100%; text-align: center;  background: #2d0c03; color: white; font-weight: bold; text-transform: uppercase;">
        Спасибо за покупку!
    </div>
    <div style="display: flex; flex-direction: row; justify-content: space-between; margin: 10px;">
        <div style="width: 50%; text-align: center;">
            <h2>Информация о заказе</h2>
        </div>
        <div style="width: 50%; text-align: center;">
            <h2>Товары в заказе</h2>
            <ul style="list-style: none; display: flex; flex-direction: row;">
                <?php \app\models\tool\Debug::p($order_items); ?>
				<?php foreach ($order_items as $item): ?>
                    <li style="width: 25%; margin: 5px;">
                        <img src="/web/upload/<?= $item->product->image; ?>">
                    </li>
				<?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>