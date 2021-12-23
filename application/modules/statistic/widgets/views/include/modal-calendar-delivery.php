<?php

/* @var $order_calendar \app\modules\order\models\entity\Order[] */

?>
<div class="modal fade" id="orders-calendar" tabindex="-1" role="dialog" aria-labelledby="orders-calendarLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orders-calendarLabel">Календарь доставок</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row calendar-orders">
                    <?php for ($i = 1; $i <= date('t'); $i++): ?>
                        <div class="col-sm-3 calendar-orders-item">
                            <?php foreach ($order_calendar as $order): ?>
                                <?php if (date('d', $order->created_at) != $i) continue; ?>
                                <a href="<?= \yii\helpers\Url::to(['/admin/order/order-backend/update/', 'id' => $order->id]); ?>" style="display:block; font-size: 9px; line-height: 1; margin: 0;"><?= $order->email; ?></a>
                            <?php endforeach; ?>
                        </div>
                    <?php endfor; ?>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>