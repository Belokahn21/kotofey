<?php
/* @var $this \yii\web\View
 * @var $models \app\modules\news\models\entity\News[]
 * @var $categories \app\modules\news\models\entity\NewsCategory[]
 * @var $sub_category \app\modules\news\models\entity\NewsCategory | null
 */

use yii\helpers\Url;
use app\widgets\Breadcrumbs;
use yii\helpers\ArrayHelper;
use app\modules\seo\models\tools\Title;
use app\modules\news\models\tools\NewsHelper;


$this->title = Title::show('Новости');

if ($sub_category !== null) {
    $this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => Url::to(['index'])];
    $this->params['breadcrumbs'][] = ['label' => $sub_category->name];
} else {
    $this->params['breadcrumbs'][] = ['label' => 'Новости'];
}

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
    <h1 class="page__title">Новости</h1>
    <div class="news-list-wrap">
        <div class="news-list-container">
            <ul class="aside-sub-categories">
                <?php foreach ($categories as $category): ?>
                    <li class="aside-sub-categories__item <?= ArrayHelper::getValue(Yii::$app->request->get('NewsSearchForm'), 'category_id') != $category->id ? '' : 'active'; ?>">
                        <a class="aside-sub-categories__link" href="<?= Url::current(['NewsSearchForm[category_id]' => $category->id]); ?>"><?= $category->name; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <ul class="news-list">
                <?php foreach ($models as $model): ?>
                    <li class="news-list__item">
                        <img class="news-list__image" src="<?= NewsHelper::getPreviewImageUrl($model); ?>">
                        <a href="<?= NewsHelper::getDetailUrl($model); ?>" class="news-list__link"><?= $model->title; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
