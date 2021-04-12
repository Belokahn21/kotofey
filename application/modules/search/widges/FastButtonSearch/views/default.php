<?php
/* @var $models \app\modules\search\models\entity\Search[] */
?>
<?php if ($models): ?>
    <ul class="search-fast-button">
        <?php foreach ($models as $model): ?>
            <li><a href=""><?= $model->category; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>