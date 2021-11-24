<?php

use app\modules\order\models\entity\Order;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $orderHistory Order[]
 * @var $profile \app\modules\user\models\entity\User
 * @var $model Order
 * @var $userBonus integer
 */

?>
<div class="info-card">

    <div class="info-card-block">
        <div class="title" data-target="#buyerInfoModal" data-toggle="modal">Покупатель</div>
        <?php if ($model->client): ?>
            <div class="text"><?= $model->client; ?></div>
        <?php endif; ?>
        <div class="text">Телефон <a href="tel:<?= $model->phone; ?>"><?= $model->phone; ?></a></div>
        <div class="text">Почта <a href="mailto:<?= $model->email; ?>"><?= $model->email; ?></a></div>
        <?php if ($model->ip): ?>
            <div class="text">IP адрес <?= $model->ip; ?></div>
        <?php endif; ?>
    </div>


    <div class="info-card-block">
        <div class="title">Список заказов</div>
        <?php if ($orderHistory): ?>
            <?php foreach ($orderHistory as $order): ?>
                <?= Html::a('Заказ #' . $order->id, Url::to(['/admin/order/order-backend/update', 'id' => $order->id]), [
                    'style' => 'display:block; line-height:1;',
                    'target' => '_blank'
                ]); ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text">Ранее покупатель не совершал покупок</div>
        <?php endif; ?>
    </div>


    <div class="info-card-block">
        <div class="title">Бонусы</div>
        <?php if ($userBonus): ?>
            <div class="text">Кол-во бонусов: <?= $userBonus; ?></div>
        <?php else: ?>
            <div class="text">Аккаунт с бонусами не найден</div>
        <?php endif; ?>
    </div>

</div>