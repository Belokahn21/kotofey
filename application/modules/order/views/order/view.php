<?php

/* @var $order \app\modules\order\models\entity\Order
 * @var $items \app\modules\order\models\entity\OrdersItems[]
 */

use app\modules\delivery\widgets\ProfileTracking\ProfileTrackingWidget;
use app\modules\acquiring\models\helpers\AcquiringHelper;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\site\models\tools\Currency;
use app\modules\site\models\tools\PriceTool;
use app\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Url;

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
        <div class="col-12 col-sm-6">
            <div class="profile-order-info">
                <div class="profile-order-info__row">
                    <div class="profile-order-info__key">Дата создания</div>
                    <div class="profile-order-info__value"><?= date('d.m.Y', $order->created_at) ?></div>
                </div>
                <?php if (!empty($order->email)): ?>
                    <div class="profile-order-info__row">
                        <div class="profile-order-info__key">Почта</div>
                        <div class="profile-order-info__value"><?= $order->email; ?></div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($order->phone)): ?>
                    <div class="profile-order-info__row">
                        <div class="profile-order-info__key">Телефон</div>
                        <div class="profile-order-info__value js-phone-mask"><?= $order->phone; ?></div>
                    </div>
                <?php endif; ?>
                <div class="profile-order-info__row">
                    <div class="profile-order-info__row">Сумма заказа</div>
                    <div class="profile-order-info__value">
                        <?php if (OrderHelper::orderSummary($order) == OrderHelper::orderSummary($order)): ?>
                            <span><?= PriceTool::format(OrderHelper::orderSummary($order)); ?> <?= Currency::getInstance()->show(); ?></span>
                        <?php else: ?>
                            <span style="text-decoration: line-through;"><?= PriceTool::format(OrderHelper::orderSummary($order)); ?> <?= Currency::getInstance()->show(); ?></span>
                            <span><?= PriceTool::format(OrderHelper::orderSummary($order)); ?> <?= Currency::getInstance()->show(); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="profile-order-info__row">
                    <div class="profile-order-info__key">Статус</div>
                    <div class="profile-order-info__value"><?= OrderHelper::getStatus($order); ?></div>
                </div>
                <div class="profile-order-info__row">
                    <div class="profile-order-info__key">Оплачено</div>
                    <div class="profile-order-info__value">
                        <?= ($order->is_paid ? Html::tag('span', 'Оплачено', ['class' => 'green']) : Html::tag('span', 'Не оплачено', ['class' => 'red'])); ?>
                        <?php if (!$order->is_paid && $order->payment_id == 1): ?>
                            <?= Html::a('Оплатить', AcquiringHelper::getInstance()->productionPaymentLink($order), ['target' => '_blank', 'class' => 'btn-main']); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="profile-order-info__row">
                    <div class="profile-order-info__key">Адрес доставки</div>
                    <div class="profile-order-info__value">
                        <?= $order->city ? "г. " . $order->city : null; ?>
                        <?= $order->street ? ", ул. " . $order->street : null; ?>
                        <?= $order->number_home ? ", дом. " . $order->number_home : null; ?>
                        <?= $order->entrance ? ", подъезд. " . $order->entrance : null; ?>
                        <?= $order->floor_house ? ", этаж. " . $order->floor_house : null; ?>
                        <?= $order->number_appartament ? ", кв. " . $order->number_appartament : null; ?>
                    </div>
                </div>
                <?php if ($order->dateDelivery): ?>
                    <div class="profile-order-info__row">
                        <div class="profile-order-info__key">Дата и время доставки</div>
                        <div class="profile-order-info__value"><?= $order->dateDelivery->date ? $order->dateDelivery->date : ''; ?><?= $order->dateDelivery->time ? ', ' . $order->dateDelivery->time : ''; ?></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-12 col-sm-6 mt-5 mt-sm-0">
            <?php if ($items): ?>
                <ul class="profile-order-products">
                    <?php foreach ($items as $item): ?>
                        <li class="profile-order-products__item">
                            <?php if ($item->product): ?>
                                <img class="profile-order-products__image" src="<?= ProductHelper::getImageUrl($item->product) ?>" alt="<?= $item->image; ?>">
                            <?php else: ?>
                                <img class="profile-order-products__image" src="/images/not-image.png" alt="<?= $item->image; ?>">
                            <?php endif; ?>
                            <?= Html::a($item->name, $item->product ? ProductHelper::getDetailUrl($item->product) : 'javascript:void(0);', ['class' => 'profile-order-products__link']); ?>
                            <div class="profile-order-products__price"><?= PriceTool::format($item->getResultPrice()); ?> <?= Currency::getInstance()->show(); ?></div>
                            <div class="profile-order-products__char">X</div>
                            <div class="profile-order-products__count"><?= $item->count; ?> шт.</div>
                            <div class="profile-order-products__summary"><?= PriceTool::format($item->count * $item->getResultPrice()); ?> <?= Currency::getInstance()->show(); ?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
    <?= ProfileTrackingWidget::widget([
        'order' => $order
    ]); ?>
</div>

