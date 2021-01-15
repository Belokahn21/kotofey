<?php

/* @var $order \app\modules\order\models\entity\Order
 * @var $items \app\modules\order\models\entity\OrdersItems[]
 */

use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\order\models\helpers\OrderHelper;
use app\models\tool\Currency;
use app\widgets\Breadcrumbs;
use app\models\tool\Price;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = "Просмотр заказа: #" . $order->id;
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => Url::to(['/user/profile/index'])];
$this->params['breadcrumbs'][] = ['label' => 'Просмотр заказа', 'url' => Url::to(['/order/order/view', 'id' => $order->id])];
?>

<div class="page">
    <?= Breadcrumbs::widget([
        'homeLink' => [
            'label' => 'Главная ',
            'url' => Yii::$app->homeUrl,
            'title' => 'Первая страница сайта зоомагазина Котофей',
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]); ?>
    <h1 class="page__title">Просмотр заказа: #<?= $order->id; ?></h1>
    <div class="row" style="width: 100%;">
        <div class="col-6">
            <table style="width:100%">
                <tr>
                    <td colspan="2" align="center">Информация о заказе</td>
                </tr>
                <tr>
                    <td>Дата создания</td>
                    <td><?= date('d.m.Y', $order->created_at) ?></td>
                </tr>
                <?php if (!empty($order->email)): ?>
                    <tr>
                        <td>Почта</td>
                        <td><?= $order->email; ?></td>
                    </tr>
                <?php endif; ?>
                <?php if (!empty($order->phone)): ?>
                    <tr>
                        <td>Телефон</td>
                        <td class="js-phone-mask"><?= $order->phone; ?></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td>Сумма заказа</td>
                    <td>
                        <?php if (OrderHelper::orderSummary($order) == OrderHelper::orderSummary($order)): ?>
                            <span><?= Price::format(OrderHelper::orderSummary($order)); ?> <?= Currency::getInstance()->show(); ?></span>
                        <?php else: ?>
                            <span style="text-decoration: line-through;"><?= Price::format(OrderHelper::orderSummary($order)); ?> <?= Currency::getInstance()->show(); ?></span>
                            <span><?= Price::format(OrderHelper::orderSummary($order)); ?> <?= Currency::getInstance()->show(); ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>Статус</td>
                    <td><?= OrderHelper::getStatus($order); ?></td>
                </tr>
                <tr>
                    <td>Оплачено</td>
                    <td><?= ($order->is_paid ? Html::tag('span', 'Оплачено', ['class' => 'green']) : Html::tag('span', 'Не оплачено', ['class' => 'red'])); ?></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">Адрес и время доставки</td>
                </tr>
                <tr>
                    <td>
                        <?= $order->city ? "г. " . $order->city : null; ?>
                        <?= $order->street ? ", ул. " . $order->street : null; ?>
                        <?= $order->number_home ? ", дом. " . $order->number_home : null; ?>
                        <?= $order->entrance ? ", подъезд. " . $order->entrance : null; ?>
                        <?= $order->floor_house ? ", этаж. " . $order->floor_house : null; ?>
                        <?= $order->number_appartament ? ", кв. " . $order->number_appartament : null; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Дата <?= $order->dateDelivery->date; ?>, время: <?= $order->dateDelivery->time; ?>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-6">
            <?php if ($items): ?>
                <ul class="profile-order-products">
                    <?php foreach ($items as $item): ?>
                        <li class="profile-order-products__item">
                            <?php if ($item->product): ?>
                                <img class="profile-order-products__image" src="<?= ProductHelper::getImageUrl($item->product) ?>" alt="<?= $item->image; ?>">
                            <?php else: ?>
                                <img class="profile-order-products__image" src="/images/not-image.png" alt="<?= $item->image; ?>">
                            <?php endif; ?>
                            <?= Html::a($item->name, $item->product ? $item->product->detail : 'javascript:void(0);', ['class' => 'profile-order-products__link']); ?>
                            <div class="profile-order-products__price"><?= Price::format($item->price); ?> <?= Currency::getInstance()->show(); ?></div>
                            <div class="profile-order-products__char">X</div>
                            <div class="profile-order-products__count"><?= $item->count; ?> шт.</div>
                            <div class="profile-order-products__summary"><?= Price::format($item->count * $item->price); ?> <?= Currency::getInstance()->show(); ?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>

