<?php
/* @var $this yii\web\View */

/* @var $categories \app\models\entity\NewsCategory[] */

/* @var $news \app\models\entity\News[] */

use app\models\tool\seo\Title;

$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['/news/']];
$this->title = Title::showTitle("Статьи");
?>
<div class="news-wrap">
    <div class="news-categories-wrap">
        <ul class="news-categories">
            <?php foreach ($categories as $category): ?>
                <li class="news-categories__item">
                    <a class="news-categories__link" href="javascript:void(0);"><?= $category->name; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <ul class="news">
        <?php foreach ($news as $new): ?>
            <li class="news__item">
                <a class="news__link" href="<?= $new->detailurl; ?>">
                    <img class="news__image" src="/upload/<?= $new->preview_image; ?>">
                </a>

                <a class="news__link" href="<?= $new->detailurl; ?>">
                    <div class="news__title">
                        <span><?= $new->title; ?></span>
                    </div>
                </a>

                <div class="news__preview"><?= $new->preview; ?></div>
                <div class="news__date">Дата публикации: <?= date('d.m.Y', $new->created_at); ?></div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>