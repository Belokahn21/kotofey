<?php
/* @var $this yii\web\View */

/* @var $model \app\modules\news\models\entity\News */

use app\modules\news\models\tools\NewsHelper;
use app\modules\news\models\entity\NewsCategory;
use app\models\tool\seo\Title;
use app\widgets\Breadcrumbs;

$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['/news/']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => [NewsHelper::getDetailUrl($model)]];
$this->title = Title::showTitle($model->title);
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
    <div class="news-detail__info">
        <div class="row justify-content-center align-items-center">
            <div class="col-sm-5">
                <div class="news-detail__date">Дата публикации: <?= date('d.m.Y', $model->created_at); ?></div>
            </div>
            <div class="col-sm-7">
                <div class="news-detail__section">Рубрика: <?= NewsCategory::findOne($model->category)->name; ?></div>
            </div>
        </div>
    </div>
	<?php if ($url = $model->detail_image ? $model->detail_image : $model->preview_image): ?>
        <img src="/upload/<?= $url; ?>" class="news-detail__image">
	<?php endif; ?>
    <div class="news-detail__content">
		<?= ($model->detail ? $model->detail : $model->preview); ?>
    </div>
    <div class="clearfix"></div>
</div>