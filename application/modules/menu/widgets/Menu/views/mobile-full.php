<?php

use yii\helpers\Url;

/* @var $models \app\modules\menu\models\entity\MenuItem[] */

?>
<?php if ($models): ?>
    <ul class="full-mobile-nav">
        <?php foreach ($models as $model): ?>
            <li class="full-mobile-nav__item"><a class="full-mobile-nav__link" href="<?= Url::to([$model->link]); ?>"><?= $model->name; ?></a></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
