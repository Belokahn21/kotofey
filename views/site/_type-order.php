<?php

use app\models\entity\Basket;

?>
<div class="type-order">
    <ul class="type-order-list">
        <li class="type-order-list__item" data-cookie="fast">
            <div class="type-order-list__item-title">Быстрый заказ</div>
            <div class="type-order-list__item-reason">
                <ul class="list-advantages">
                    <li class="advantage-item advantage-false">Нет бонусов</li>
                </ul>
            </div>
        </li>
        <li class="type-order-list__item-choice">
            <div class="type-order-list__choice-title">Выберите вариант заказа</div>
			<?php if (Basket::getInstance()->cash() < 500): ?>
                <div class="type-order-list__choice-sub-title alarm">Доставка: 100р</div>
			<?php else: ?>
                <div class="type-order-list__choice-sub-title good">Бесплатная доставка</div>
			<?php endif; ?>
        </li>
        <li class="type-order-list__item" data-cookie="normal">
            <div class="type-order-list__item-title">Обычный заказ</div>
            <div class="type-order-list__item-reason">
                <ul class="list-advantages">
                    <li class="advantage-item advantage-true">Вам начислят бонусы</li>
                    <li class="advantage-item advantage-true">Можно использовать промокод</li>
                </ul>
            </div>
        </li>
    </ul>
</div>