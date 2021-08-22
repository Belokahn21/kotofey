<?php


/* @var $this yii\web\View
 * @var $model \app\modules\news\models\entity\News
 * @var $models_current_category \app\modules\news\models\entity\News[]
 * @var $models_all \app\modules\news\models\entity\News[]
 */

use app\widgets\Breadcrumbs;
use app\modules\seo\models\tools\Title;
use app\modules\news\models\tools\NewsHelper;
use app\modules\user\models\helpers\UserHelper;

$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['/news/']];
$this->params['breadcrumbs'][] = ['label' => $model->title];
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
    <div class="news-detail-container">
        <div class="news-detail-sidebar">
            <?php if ($models_current_category): ?>
                <div class="news-detail-sidebar__title">Новости похожей рубрики</div>
                <div class="other-news">
                    <?php foreach ($models_current_category as $model_current_category): ?>
                        <div class="other-news-item">
                            <div class="other-news-item__title"><?= $model_current_category->title; ?></div>
                            <div class="other-news-item__preview"><?= $model_current_category->preview; ?></div>
                            <div class="other-news-item-group">
                                <div class="other-news-item__date"><?= date('d.m.Y', $model_current_category->created_at); ?></div>
                                <a href="<?= NewsHelper::getDetailUrl($model_current_category); ?>" class="other-news-item__next">Читать далее</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="news-detail-content">
            <h1 class="page__title"><?= $model->title; ?></h1>
            <?php if ($model->author): ?>
                <div class="news-detail-author">
                    <div class="news-detail-author__avatar"><img src="<?= UserHelper::getAvatar($model->author); ?>"/></div>
                    <div class="news-detail-author-data">
                        <div class="news-detail-author-data__title">Автор <a href="#"><?= UserHelper::getFullName($model->author); ?></a></div>
                        <div class="news-detail-author-data__date">Опубликовано <?= date('', $model->created_at) ?></div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="news-detail-text"><?= $model->detail; ?></div>
        </div>
        <div class="news-detail-sidebar">
            <?php if ($models_all): ?>
                <div class="news-detail-sidebar__title">Все новости</div>
                <div class="other-news">
                    <?php foreach ($models_all as $model_all): ?>
                        <div class="other-news-item">
                            <div class="other-news-item__title"><?= $model_all->title; ?></div>
                            <div class="other-news-item__preview"><?= $model_all->preview; ?></div>
                            <div class="other-news-item-group">
                                <div class="other-news-item__date"><?= date('d.m.Y', $model_all->created_at); ?></div>
                                <a href="<?= NewsHelper::getDetailUrl($model_all); ?>" class="other-news-item__next">Читать далее</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>

</div>
