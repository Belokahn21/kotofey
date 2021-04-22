<?php
/* @var $models \app\modules\reviews\models\entity\Reviews[] */
?>


<?php if ($models): ?>

    <ul>
        <?php foreach ($models as $model): ?>
            <li><?= $model->text; ?></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    Отзывы отсуствуют
<?php endif; ?>
