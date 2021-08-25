<?php

use yii\helpers\Html;

/* @var $models \app\modules\search\models\entity\SearchQuery[]
 * @var $this \yii\web\View
 */
?>
<?php if ($this->beginCache(__FILE__ . __METHOD__, ['duration' => 3600 * 24 * 7])): ?>
    <?php if ($models): ?>
        <div class="page-title__group">
            <h2 class="page-title">Быстрый поиск</h2>
        </div>
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
    <?php $this->endCache(); ?>
<?php endif; ?>