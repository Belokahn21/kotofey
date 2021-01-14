<?php

use yii\helpers\Url;

/* @var $models \app\modules\menu\models\entity\MenuItem[] */

?>
<?php if ($models): ?>
    <ul class="header-menu">
        <?php foreach ($models as $model): ?>
            <li class="header-menu__item"><a class="header-menu__link" href="<?= Url::to([$model->link]); ?>"><?= $model->name; ?></a></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
