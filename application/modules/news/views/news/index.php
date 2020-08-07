<?php
/* @var $this \yii\web\View
 * @var $models \app\modules\news\models\entity\News[]
 * @var $categories \app\modules\news\models\entity\NewsCategory[]
 */

use app\models\tool\seo\Title;
use app\modules\news\models\tools\NewsHelper;

$this->title = Title::showTitle('Новости');
?>
<div class="news-list-wrap">
    <ul class="breadcrumbs">
        <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="javascript:void(0);">Главная</a></li>
        <li class="breadcrumbs__item active"><a class="breadcrumbs__link" href="javascript:void(0);">Доставка и оплата</a></li>
    </ul>
    <h1 class="page__title">Новости</h1>
    <div class="news-list-container">
        <ul class="aside-sub-categories">
			<?php foreach ($categories as $category): ?>
                <li class="aside-sub-categories__item"><a class="aside-sub-categories__link" href="javascript:void(0);"><?= $category->name; ?></a></li>
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
