<?php

use app\models\tool\seo\Title;
use app\models\tool\Currency;
use app\models\tool\Price;
use yii\helpers\Html;
use app\models\helpers\OrderHelper;

/* @var $order \app\models\entity\Order */

$this->title = Title::showTitle("Заказ №" . $order->id);
$this->params['breadcrumbs'][] = ['label' => 'Список заказов', 'url' => ['/order/']];
$this->params['breadcrumbs'][] = ['label' => 'Заказ №' . $order->id, 'url' => ['/order/' . $order->id . '/']];
?>
<section class="detail-order">
    <div class="detail-order-info-wrap">
        <h1 class="detail-order-info__title"><?= "Заказ №" . $order->id; ?></h1>
        <table class="detail-order-info">
            <tr>
                <td>
                    Дата покупки
                </td>
                <td>
                    <?= date("d.m.Y", $order->created_at); ?>
                </td>
            </tr>
            <tr>
                <td>
                    Сумма заказа
                </td>
                <td>
                    <?= Price::format(OrderHelper::orderSummary($order->id)); ?> <?= (new Currency())->show(); ?>
                </td>
            </tr>
            <tr>
                <td>
                    Статус
                </td>
                <td>
                    <?= $order->getStatus(); ?>
                </td>
            </tr>
            <tr>
                <td>
                    Оплачен
                </td>
                <td>
                    <?php if ($order->is_paid): ?>
                        <span class="green">Оплачен</span>
                    <?php else: ?>
                        <span class="red">Не оплачен</span>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>
    <div class="detail-order-info-items-wrap">
<?php if ($items): ?>
            <h1 class="detail-order-info-items__title">Товары в заказе</h1>
<?php /* @var $item \app\models\entity\OrdersItems */ ?>
            <ul class="detail-order-info-items-list">
<?php foreach ($items as $item): ?>
                    <li class="detail-order-info-items-list-item">
                        <a href="<?= $item->product->detail; ?>" class="detail-order-info-items-list-item__link">
                            <img class="detail-order-info-items-list-item__image" src="/web/upload/<?= $item->product->image ?>">
                            <div class="detail-order-info-items-list-item__title">
                                <h3><?= $item->name; ?></h3>
                            </div>
                        </a>
                    </li>
<?php endforeach; ?>
            </ul>
<?php else: ?>
            К сожалению вы ничего не купили
<?php endif; ?>
    </div>
</section>
