<?php
/* @var $this \yii\web\View
 * @var $models \app\modules\news\models\entity\News[]
 */

use app\models\tool\seo\Title;

$this->title = Title::showTitle('Новости');
?>

<div class="page">
    <ul class="breadcrumbs">
        <li class="breadcrumbs__item"><a class="breadcrumbs__link" href="javascript:void(0);">Главная</a></li>
        <li class="breadcrumbs__item active"><a class="breadcrumbs__link" href="javascript:void(0);">Доставка и оплата</a></li>
    </ul>
    <h1 class="page__title">Новости</h1>
	<?php if ($models): ?>
		<?php foreach ($models as $model): ?>
            <li><?= $model->title; ?></li>
		<?php endforeach; ?>
	<?php endif; ?>
</div>
