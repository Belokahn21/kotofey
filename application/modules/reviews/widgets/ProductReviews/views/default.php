<?php
/* @var $models \app\modules\reviews\models\entity\Reviews[] */
?>

<ul>
    <?php foreach ($models as $model): ?>
        <li><?= $model->text; ?></li>
    <?php endforeach; ?>
</ul>