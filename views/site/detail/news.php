<?php
/* @var $this yii\web\View */

/* @var $model \app\models\entity\News */

use app\models\tool\seo\Title;

$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['/news/']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => [$model->detailurl]];
$this->title = Title::showTitle($model->title);
?>
<div class="news-detail__info">
    <h1><?= $model->title; ?></h1>
    <div class="row justify-content-center align-items-center">
        <div class="col-sm-5">
            <div class="news-detail__date">Дата публикации: <?= date('d.m.Y', $model->created_at); ?></div>
        </div>
        <div class="col-sm-7">
            <div class="news-detail__section">Рубрика: <?= \app\models\entity\NewsCategory::findOne($model->category)->name; ?></div>
        </div>
    </div>
</div>
<img src="/web/upload/<?= ($model->detail_image ? $model->detail_image : $model->preview_image); ?>" class="news-detail__image">
<div class="news-detail__content">
    <?= ($model->detail ? $model->detail : $model->preview); ?>
</div>
<div class="clearfix"></div>