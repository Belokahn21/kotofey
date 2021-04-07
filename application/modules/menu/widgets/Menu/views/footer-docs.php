<?php

use yii\helpers\Url;

/* @var $models \app\modules\menu\models\entity\MenuItem[] */

?>
<?php if ($models): ?>
    <div class="footer-docs">
        <?php foreach ($models as $model): ?>
            <div class="footer-docs__item"><a class="footer-docs__link" href="<?= Url::to([$model->link]); ?>"><?= $model->name; ?></a></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
