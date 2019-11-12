<?php

use app\models\entity\Order;
use app\models\entity\Product;
use app\models\entity\User;

?>
<div class="admin-panel-wrap">
    <ul class="admin-panel-list">
        <li class="admin-panel-list__item link"><a href="/">Сайт</a></li>
        <li class="admin-panel-list__item link"><a href="/admin/">Панель управления</a></li>
        <li class="admin-panel-list__item link"><a href="/admin/order/">Зказы <span class="actual-count"><?= Order::find()->count(); ?></span></a></li>
        <li class="admin-panel-list__item link"><a href="/admin/catalog/">Товары <span class="actual-count"><?= Product::find()->count(); ?></span></a></li>
        <li class="admin-panel-list__item link"><a href="/admin/user/">Пользователи <span class="actual-count"><?= User::find()->count(); ?></span></a></li>
        <li class="admin-panel-list__item"><a href="#"><span>TS: <span class="admin-panel-list__item-ts"><?= time(); ?></span></span></a></li>
        <li class="admin-panel-list__item"><a href="#">Сегодня: 01.11.2019</a></li>
    </ul>
    <div class="clearfix"></div>
</div>