<?php if (isset($tracking_info->entity) && isset($tracking_info->entity->uuid)) { ?>
    <?php // \app\modules\site\models\tools\Debug::p($tracking_info->entity); ?>
    <div class="order-tracking">
        <div class="order-tracking-block">
            <div class="order-tracking-block__title">Информация о доставке</div>
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
            </div>
        </div>
        <div class="order-tracking-block">
            <div class="order-tracking-block__title">Статус доставки</div>
            <div class="order-tracking-block__content">


                <?php if (isset($tracking_info->entity->statuses)): ?>
                    <div class="order-tracking-list">
                        <?php foreach ($tracking_info->entity->statuses as $status): ?>
                            <div class="order-tracking-list__row">
                                <div class="order-tracking-list__item name"><?= $status->name; ?></div>
                                <div class="order-tracking-list__item">
                                    Дата: <?= explode('T', $status->date_time)[0]; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>


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
<?php } ?>
