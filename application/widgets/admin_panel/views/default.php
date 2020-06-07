<?php

use app\modules\order\models\entity\Order;
use app\models\entity\Product;
use app\models\entity\User;
use yii\helpers\Url;

?>
<div class="admin-panel-wrap">
    <ul class="admin-panel-list">
        <li class="admin-panel-list__item link"><a href="/">Сайт</a></li>
        <li class="admin-panel-list__item link"><a href="/admin/">Панель управления</a></li>
        <li class="admin-panel-list__item link"><a href="<?= Url::to(['/admin/order/order-backend/index']); ?>">Заказы <span class="actual-count"><?= Order::find()->count(); ?></span></a></li>
        <li class="admin-panel-list__item link"><a href="<?= Url::to(['/admin/catalog/product-backend/index']); ?>">Товары <span class="actual-count"><?= Product::find()->count(); ?></span></a></li>
        <li class="admin-panel-list__item link"><a href="<?= Url::to(['/admin/user/user-backend/index']); ?>">Пользователи <span class="actual-count"><?= User::find()->count(); ?></span></a></li>
        <li class="admin-panel-list__item"><a href="#"><span>TS: <span class="admin-panel-list__item-ts"><?= time(); ?></span></span></a></li>
        <li class="admin-panel-list__item"><a href="#">Сегодня: <?= date('d.m.Y'); ?></a></li>
        <li class="admin-panel-list__item"><a href="<?= Url::to(['admin/cache']) ?>">Сбросить кеш</a></li>
    </ul>
    <div class="clearfix"></div>
</div>