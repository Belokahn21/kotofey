<?php

use yii\helpers\Html;

/* @var $models \app\modules\search\models\entity\SearchQuery[] */
?>
<?php if ($models): ?>
    <ul class="search-fast-button">
        <?php foreach ($models as $model): ?>
            <li class="search-fast-button__item">
                <a class="search-fast-button__link" href="<?= '/search/?Search[search]=' . $model->text; ?>">
                    <div><?= $model->text; ?></div>
                    <img src="/images/cursor.png">
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>