<?php

use yii\helpers\Url;

/* @var $news \app\models\entity\News[] */
?>
<div class="index-news__wrap">
    <h2 class="homepage-providers__title">Интересные новости</h2>
    <ul class="index-news">
        <?php foreach ($news as $new): ?>
            <li class="index-news__item">
                <a href="<?= Url::to(['/news/' . $new->slug . '/']); ?>" class="index-news__link">
                    <img src="/upload/<?= $new->preview_image; ?>" class="index-news__image">
                </a>
                <a href="<?= Url::to(['/news/' . $new->slug . '/']); ?>" class="index-news__link">
                    <h3 class="index-news__title"><?= $new->title; ?></h3>
                </a>
                <div class="index-news__preview">
                    <?= $new->preview; ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="index-news__control">
        <a class="index-news__control-link" href="<?= Url::to(['site/news']); ?>">Читать больше</a>
    </div>
</div>