<?php

use yii\helpers\Url;

/* @var $models \app\modules\menu\models\entity\MenuItem[] */
?>
<?php if ($models): ?>
    <ul class="footer-nav">
        <?php foreach ($models as $model): ?>
            <li class="footer-nav__item"><a class="footer-nav__link" href="<?= Url::to([$model->link]); ?>"><?= $model->name; ?></a></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
