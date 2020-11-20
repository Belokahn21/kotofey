<?php

use yii\helpers\Url;
use app\modules\news\models\tools\NewsHelper;

/* @var $news \app\modules\news\models\entity\News[] */
?>
<div class="page-title__group">
    <h2 class="page-title">Последние новости</h2><a class="page-title__link" href="<?= Url::to(['/news/']) ?>">Все новости</a>
</div>
<div class="last-news">
    <?php foreach ($news as $model): ?>
        <div class="last-news__item">
            <div class="label"><?= $model->categoryModel->name; ?></div>
            <img alt="<?= $model->title; ?>" class="last-news__image" src="<?= NewsHelper::getPreviewImageUrl($model); ?>"/>
            <div class="last-news__title"><?= $model->title; ?></div>
            <div class="last-news__preview"><?= $model->preview; ?></div>
            <a class="last-news__go-detail" href="<?= NewsHelper::getDetailUrl($model); ?>">Подробнее</a>
        </div>
    <?php endforeach; ?>
</div>