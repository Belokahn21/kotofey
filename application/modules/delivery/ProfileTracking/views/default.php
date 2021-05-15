<?php if (isset($tracking_info->entity) && isset($tracking_info->entity->uuid)) { ?>
    <?php \app\modules\site\models\tools\Debug::p($tracking_info->entity); ?>
    <div class="order-tracking">
        <div class="order-tracking-block">
            <div class="order-tracking-block__title">Информация о доставке</div>
            <div class="order-tracking-block__content"></div>
        </div>
        <div class="order-tracking-block">
            <div class="order-tracking-block__title">Статус доставки</div>
            <div class="order-tracking-block__content">


                <?php if (isset($tracking_info->entity->statuses)): ?>
                    <div class="order-tracking-status">
                        <?php foreach ($tracking_info->entity->statuses as $status): ?>
                            <div class="order-tracking-status__item">
                                <ul>
                                    <li><?= $status->name; ?></li>
                                    <li>Дата: <?= explode('T', $status->date_time)[0]; ?></li>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>


            </div>
        </div>
        <div class="order-tracking-block">
            <div class="order-tracking-block__title">Товары в заказе</div>
            <div class="order-tracking-block__content"></div>
        </div>
    </div>
<?php } ?>
