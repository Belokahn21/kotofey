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
$this->params['breadcrumbs'][] = ['label' => 'Просмотр заказа', 'url' => Url::to(['/profile/order', 'id' => $order->id])];
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
    <div class="row">
        <div class="col-6">
            <table width="100%">
                <tr>
                    <td>Дата создания</td>
                    <td><?= date('d.m.Y', $order->created_at) ?></td>
                </tr>
                <tr>
                    <td>Сумма заказа</td>
                    <td>
                        <?php if (OrderHelper::orderSummary($order->id) == OrderHelper::orderSummary($order->id, true)): ?>
                            <span><?= Price::format(OrderHelper::orderSummary($order->id)); ?> <?= Currency::getInstance()->show(); ?></span>
                        <?php else: ?>
                            <span style="text-decoration: line-through;"><?= Price::format(OrderHelper::orderSummary($order->id)); ?> <?= Currency::getInstance()->show(); ?></span>
                            <span><?= Price::format(OrderHelper::orderSummary($order->id, true)); ?> <?= Currency::getInstance()->show(); ?></span>
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
            </table>
        </div>
        <div class="col-6">
            <?php if ($items): ?>
                <ul class="profile-order-products">
                    <?php foreach ($items as $item): ?>
                        <li class="profile-order-products__item">
                            <?= Html::a($item->name, $item->product ? $item->product->detail : 'javascript:void(0);', ['class' => 'profile-order-products__link']); ?>
                            <?php if ($item->product): ?>
                                <img class="profile-order-products__image" src="<?= ProductHelper::getImageUrl($item->product) ?>" alt="<?= $item->image; ?>">
                            <?php else: ?>
                                <img class="profile-order-products__image" src="/images/not-image.png" alt="<?= $item->image; ?>">
                            <?php endif; ?>
                            <div class="profile-order-products__price"><?= Price::format($item->price); ?></div>
                            <div class="profile-order-products__char">X</div>
                            <div class="profile-order-products__count"><?= $item->count; ?></div>
                            <div class="profile-order-products__summary"><?= Price::format($item->count * $item->price); ?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>

