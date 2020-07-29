<?php

/* @var $order \app\modules\order\models\entity\Order
 * @var $items \app\modules\order\models\entity\OrdersItems[]
 */

use app\modules\order\models\helpers\OrderHelper;
use app\models\tool\Currency;

$this->title = "Просмотр заказа: #" . $order->id;
?>

<div class="page">
    <ul class="breadcrumbs">
        <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="javascript:void(0);">Главная</a></li>
        <li class="breadcrumbs__item active"><a class="breadcrumbs__link" href="javascript:void(0);">Доставка и оплата</a></li>
    </ul>
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
                    <td><?= OrderHelper::orderSummary($order->id); ?> <?= Currency::getInstance()->show(); ?></td>
                </tr>
                <tr>
                    <td>Статус</td>
                    <td><?= OrderHelper::getStatus($order); ?></td>
                </tr>
                <tr>
                    <td>Оплачено</td>
                    <td><?= ($order->is_paid ? 'Оплачено' : 'Не оплачено'); ?></td>
                </tr>
            </table>
        </div>
        <div class="col-6">
			<?php if ($items): ?>
                <ul>
					<?php foreach ($items as $item): ?>
                        <li class="row">

                            <div class="col-3">
                                <img width="100" src="/upload/<?= $item->product->image; ?>">
                            </div>

                            <div class="col-3">
								<?= $item->name; ?>
                            </div>

                            <div class="col-2">
								<?= $item->price; ?>
                            </div>

                            <div class="col-2">
								<?= $item->count; ?>
                            </div>

                            <div class="col-2">
								<?= $item->count * $item->price; ?>
                            </div>
                        </li>
					<?php endforeach; ?>
                </ul>
			<?php endif; ?>
        </div>
    </div>
</div>

