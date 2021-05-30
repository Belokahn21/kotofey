<?php

use yii\helpers\Url;

/* @var $query array */
?>
<?php if ($query): ?>
    <div class="mobile-last-queries-container">

        <div class="mobile-search-title">
            Последние запросы
        </div>

        <div class="mobile-last-queries">
            <?php foreach ($query as $item): ?>
                <a class="mobile-last-queries__link" href="<?= Url::to('/search/?Search[search]=' . $item) ?>"><?= $item; ?></a>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
