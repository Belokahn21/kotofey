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
    <div class="title" data-target="#buyerInfoModal" data-toggle="modal">Покупатель</div>
    <?php if ($model->client): ?>
        <div class="text"><?= $model->client; ?></div>
    <?php endif; ?>
    <div class="text">Телефон <a href="tel:<?= $model->phone; ?>"><?= $model->phone; ?></a></div>
    <div class="text">Почта <a href="mailto:<?= $model->email; ?>"><?= $model->email; ?></a></div>
    <?php if ($model->ip): ?>
        <div class="text">IP адрес <?= $model->ip; ?></div>
    <?php endif; ?>

    <!-- Modal -->
    <div class="modal fade" id="buyerInfoModal" tabindex="-1" role="dialog" aria-labelledby="buyerInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="buyerInfoModalLabel">Информация о клиенте</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <?php if ($profile): ?>
                        <h4>Пользователь</h4>
                        <div>Дата регистрации: <?= date('d.m.Y H:i:s', $profile->created_at); ?></div>
                    <?php endif; ?>


                    <h4>Бонусы</h4>
                    <?php if ($userBonus): ?>
                        <div>Кол-во бонусов: <?= $userBonus; ?></div>
                    <?php else: ?>
                        <div>Аккаунт с бонусами не найден</div>
                    <?php endif; ?>

                    <h4>Список покупок</h4>
                    <?php if ($orderHistory): ?>
                        <?php foreach ($orderHistory as $order): ?>
                            <?= Html::a('Заказ #' . $order->id, Url::to(['/admin/order/order-backend/update', 'id' => $order->id]), [
                                'style' => 'display:block;',
                                'target' => '_blank'
                            ]); ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div>Ранее покупатель не совершал покупок</div>
                    <?php endif; ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </div>
    </div>

</div>