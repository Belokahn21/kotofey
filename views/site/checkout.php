<?php

/* @var $this yii\web\View
 * @var $order \app\models\entity\Order
 * @var $billing \app\models\entity\user\Billing
 * @var $user \app\models\entity\User
 * @var $delivery \app\models\entity\Delivery[]
 * @var $payment \app\models\entity\Payment[]
 */

use app\models\tool\seo\Title;
use app\models\entity\Basket;
use app\models\tool\Currency;

$this->title = Title::showTitle("Оформление заказа");
$this->params['breadcrumbs'][] = ['label' => 'Корзина', 'url' => ['/basket/']];
$this->params['breadcrumbs'][] = ['label' => 'Оформление заказа', 'url' => ['/checkout/']];
?>
<ul class="type-order-list">
    <li class="type-order-item" data-order-type="fast">
        <div class="type-order-title">Быстрая покупка</div>
        <ul class="type-order-advanages minuses">
            <li class="type-order-advanage">- Не начислят бонусы</li>
            <li class="type-order-advanage">- Нет промокода</li>
            <li class="type-order-advanage">- Звонок оператора</li>
        </ul>
    </li>
    <li class="type-order-item no-hover">
        <div class="type-order-title">Выберите вариант заказа</div>
        <?php if (Basket::getInstance()->cash() > 500): ?>
            <div class="type-order-description green">Бесплатная доставка</div>
        <?php else: ?>
            <div class="type-order-description red">Доставка 100 <?= Currency::getInstance()->show(); ?></div>
        <?php endif; ?>
    </li>
    <li class="type-order-item" data-order-type="simple">
        <div class="type-order-title">Обычная покупка</div>
        <ul class="type-order-advanages pluses">
            <li class="type-order-advanage">+ Промокод</li>
            <li class="type-order-advanage">+ Начислят бонусы</li>
            <li class="type-order-advanage">+ Нет звонка оператора</li>
        </ul>
    </li>
</ul>

<div class="order-type-form-wrap">
    <div class="order-type-form fast">
        <h3 class="order-type-form__title">Быстрый заказ</h3>
        <div class="container">
            <div class="row">
                <div class="col">
                    <?php if (Yii::$app->user->isGuest): ?>
                        <?= $this->render('checkout/guest/fast', [
                            'user' => $user,
                        ]); ?>
                    <?php else: ?>
                        <?= $this->render('checkout/user/fast'); ?>
                    <?php endif; ?>
                </div>
                <?= $this->render('checkout/list-checkout'); ?>
            </div>
        </div>
    </div>
    <div class="order-type-form simple">
        <h3 class="order-type-form__title">Обычный заказ</h3>
        <div class="container">
            <div class="row">
                <div class="col">
                    <?php if (Yii::$app->user->isGuest): ?>
                        <?= $this->render('checkout/guest/full', [
                            'order' => $order,
                            'delivery' => $delivery,
                            'payment' => $payment,
                            'billing' => $billing,
                            'user' => $user,
                        ]); ?>
                    <?php else: ?>
                        <?= $this->render('checkout/user/full', [
                            'order' => $order,
                            'delivery' => $delivery,
                            'payment' => $payment,
                            'billing' => $billing,
                        ]); ?>
                    <?php endif; ?>
                </div>
                <?= $this->render('checkout/list-checkout'); ?>
            </div>
        </div>
    </div>
</div>