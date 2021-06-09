<?php
/* @var $tracking_info Object */
if (!$tracking_info->OperationHistoryData || !$tracking_info->OperationHistoryData->historyRecord) return;
$order_info = array_reverse($tracking_info->OperationHistoryData->historyRecord);

?>


<div class="order-tracking">
    <div class="order-tracking-block">
        <div class="order-tracking-block__title">Статус доставки</div>
        <div class="order-tracking-block__content">


            <div class="order-tracking-list">

                <?php foreach ($order_info as $item): ?>
                    <?php if (!isset($item->OperationParameters)) continue; ?>
                    <div class="order-tracking-list__row">
                        <div class="order-tracking-list__item name"><?= $item->OperationParameters->OperType->Name; ?></div>
                        <div class="order-tracking-list__item">
                            Дата: <?= explode('T', $item->OperationParameters->OperDate)[0]; ?>
                        </div>
                    </div>

                <?php endforeach; ?>
            </div>


        </div>
    </div>
    <?php if (isset($tracking_info->entity->packages)): ?>
        <?php $packages = $tracking_info->entity->packages; ?>
        <div class="order-tracking-block">
            <div class="order-tracking-block__title">Товары в заказе</div>
            <div class="order-tracking-block__content">
                <div class="order-tracking-list">
                    <?php foreach ($packages as $package): ?>
                        <?php foreach ($package->items as $item): ?>
                            <div class="order-tracking-list__row">
                                <div class="order-tracking-list__item name"><?= $item->name; ?></div>
                                <div class="order-tracking-list__item">Кол-во: <?= $item->amount; ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>
    <?php endif; ?>

</div>
