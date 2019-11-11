<?php

use app\models\entity\Basket;
use app\models\tool\Currency;
use app\models\tool\Price;

?>
<div class="col">
    <div class="checkout-summary-wrap">
        <ul class="checkout-summary">
            <li class="checkout-summary-item">
                <div class="checkout-summary__key">Сумма заказа</div>
                <div class="checkout-summary__value"><?= Price::format(Basket::getInstance()->cash()); ?> <?= Currency::getInstance()->show(); ?></div>
            </li>
            <?php if (Basket::getInstance()->cash() < 500): ?>
                <li class="checkout-summary-item">
                    <div class="checkout-summary__key">Доставка</div>
                    <div class="checkout-summary__value">100 <?= Currency::getInstance()->show(); ?></div>
                </li>
                <li class="checkout-summary-item">
                    <div class="checkout-summary__key">Итого</div>
                    <div class="checkout-summary__value"><?= Price::format(Basket::getInstance()->cash() + 100); ?> <?= Currency::getInstance()->show(); ?></div>
                </li>
            <?php else: ?>
                <li class="checkout-summary-item">
                    <div class="checkout-summary__key">Итого</div>
                    <div class="checkout-summary__value"><?= Price::format(Basket::getInstance()->cash()); ?> <?= Currency::getInstance()->show(); ?></div>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <ul class="checkout-total-items">
        <?php foreach (Basket::findAll() as $item): ?>
            <li class="checkout-total-item">
                <div class="checkout-total-item__image-wrap">
                    <img src="/web/upload/<?= $item->getProduct()->image; ?>">
                </div>
                <div class="checkout-total-item__title">
                    <a href="<?= $item->getProduct()->detail; ?>" class="checkout-total-item__link"><?= $item->getProduct()->name; ?></a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>