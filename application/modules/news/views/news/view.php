<?php
/* @var $this yii\web\View */

/* @var $model \app\modules\news\models\entity\News */

use app\modules\news\models\tools\NewsHelper;
use app\modules\news\models\entity\NewsCategory;
use app\models\tool\seo\Title;
use app\widgets\Breadcrumbs;

$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['/news/']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => [NewsHelper::getDetailUrl($model)]];
$this->title = Title::show($model->title);
?>
<div class="page">

    <?= Breadcrumbs::widget([
        'homeLink' => [
            'label' => 'Главная ',
            'url' => Yii::$app->homeUrl,
            'title' => 'Первая страница сайта зоомагазина Котофей',
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]); ?>
    <h1><?= $model->title; ?></h1>


    <div class="news-summary">
        <div class="news-summary__item">
            <div class="news-summary__key">Дата публикации</div>
            <div class="news-summary__value"><?= date('d.m.Y', $model->created_at); ?></div>
        </div>
        <div class="news-summary__item">
            <div class="news-summary__key">Рубрика</div>
            <div class="news-summary__value"><?= NewsCategory::findOne($model->category)->name; ?></div>
        </div>
        <div class="news-summary__item">
            <div class="news-summary__key">Автор</div>
            <div class="news-summary__value">Редактор</div>
        </div>
    </div>

    <div class="news-detail">
        <img alt="<?= $model->title; ?>" class="news-detail__detail-img" src="<?= NewsHelper::getDetailImage($model, true); ?>">
        <?= ($model->detail ? $model->detail : $model->preview); ?>
    </div>
</div>
