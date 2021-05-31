<?php
/* @var $tracking_info Object */
if (!$tracking_info->OperationHistoryData || !$tracking_info->OperationHistoryData->historyRecord) return;
$order_info = $tracking_info->OperationHistoryData->historyRecord;

?>


<div class="order-tracking">
    <?php /*
     <div class="order-tracking-block">
        <div class="order-tracking-block__title">Информация о посылке</div>
        <div class="order-tracking-block__content">
            <?php if (isset($tracking_info->entity->sender)): ?>
                <?php $sender = $tracking_info->entity->sender; ?>
                <div class="order-tracking-row">
                    <div class="order-tracking-row__key title">Отправитель</div>
                    <div class="order-tracking-row__value"></div>
                </div>
                <div class="order-tracking-row">
                    <div class="order-tracking-row__key">Организация</div>
                    <div class="order-tracking-row__value"><?= $sender->company; ?></div>
                </div>
                <div class="order-tracking-row">
                    <div class="order-tracking-row__key">Имя отправителя</div>
                    <div class="order-tracking-row__value"><?= $sender->name; ?></div>
                </div>
            <?php endif; ?>
            <?php if (isset($tracking_info->entity->recipient)): ?>
                <?php $recipient = $tracking_info->entity->recipient; ?>
                <div class="order-tracking-row">
                    <div class="order-tracking-row__key title">Поулчатель</div>
                    <div class="order-tracking-row__value"></div>
                </div>
                <div class="order-tracking-row">
                    <div class="order-tracking-row__key">Имя получателя</div>
                    <div class="order-tracking-row__value"><?= $recipient->name; ?></div>
                </div>
                <div class="order-tracking-row">
                    <div class="order-tracking-row__key">Телефон</div>
                    <div class="order-tracking-row__value"><?php foreach ($recipient->phones as $phone) echo $phone->number; ?></div>
                </div>
            <?php endif; ?>
            <?php if (isset($tracking_info->entity->packages)): ?>
                <?php $packages = $tracking_info->entity->packages; ?>
                <div class="order-tracking-row">
                    <div class="order-tracking-row__key title">Посылка</div>
                    <div class="order-tracking-row__value"></div>
                </div>
                <?php foreach ($packages as $package): ?>
                    <div class="order-tracking-row">
                        <div class="order-tracking-row__key">Вес, (грамм)</div>
                        <div class="order-tracking-row__value"><?= $package->weight; ?></div>
                    </div>
                    <div class="order-tracking-row">
                        <div class="order-tracking-row__key">ШхВхД, (см)</div>
                        <div class="order-tracking-row__value"><?= $package->width; ?>x<?= $package->height; ?>x<?= $package->length; ?></div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

 */ ?>
    <div class="order-tracking-block">
        <div class="order-tracking-block__title">Статус доставки</div>
        <div class="order-tracking-block__content">


            <div class="order-tracking-list">

                <?php foreach ($order_info as $item): ?>
                    <?php //\app\modules\site\models\tools\Debug::p($item->OperationParameters->OperType->Name); ?>
                    <?php if (!isset($item->OperationParameters)) continue; ?>
                    <div class="order-tracking-list__row">
                        <div class="order-tracking-list__item name"><?= $item->OperationParameters->OperType->Name; ?></div>
                        <div class="order-tracking-list__item">
                            Дата: Не указано
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
