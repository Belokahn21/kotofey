<?php

use app\models\tool\seo\Title;

/* @var $user \app\models\entity\User */

$this->title = Title::showTitle("Профиль пользователя " . $user->name); ?>
<section>
    <h1>Пользватель #<?= $user->id; ?></h1>
</section>
