<?php

use yii\helpers\Html;

/* @var $order \app\modules\order\models\entity\Order */

?>
<?= Html::a('Что сказать?', 'javascript:void(0);', ['class' => 'btn-main', 'data-target' => '#callCenterModal', 'data-toggle' => 'modal']) ?>


<div class="modal fade" id="callCenterModal" tabindex="-1" role="dialog" aria-labelledby="callCenterModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="callCenterModalTitle">Диалог с клиентом</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseAgreeOrder" aria-expanded="false" aria-controls="collapseAgreeOrder">
                    Поступил заказ, нужно согласовать
                </button>
                <div class="collapse" id="collapseAgreeOrder">
                    <div class="card card-body">
                        <p>- Добрый день. Это зоомагазин Котофей. Поступил заказ на ваш номер телефона.</p>
                        <p>- Заказ делали?</p>
                        <p>- Тогда давайте сверим позиции в заказе. У вас в заказе:</p>
                        <ul>
							<?php foreach ($order->items as $item): ?>
                                <li><?= $item->count; ?> * <?= $item->price; ?> = <?= $item->count * $item->price; ?><?= $item->name; ?></li>
							<?php endforeach; ?>
                        </ul>
                        <p>- Всё верно?</p>
                        <p>- Хорошо, тогда доставим <?= $order->dateDelivery->date ?> <?= $order->dateDelivery->time; ?></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
