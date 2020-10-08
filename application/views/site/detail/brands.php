<?php
/* @var $this yii\web\View */

/* @var $model \app\modules\catalog\models\entity\InformersValues */

use app\models\tool\seo\Title;

$this->params['breadcrumbs'][] = ['label' => 'Бренды', 'url' => ['/brands/']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['/brands/' . $model->id . '/']];
$this->title = Title::showTitle($model->name);
?>

<section class="article-detail">
    <h1 class="article-detail__title"><?= $model->name; ?></h1>
<?php if (!empty($model->detail_image)): ?>
        <img class="article-detail-image" src="<?= $model->detail_image; ?>" alt="<?= $model->name ?>" title="<?= $model->name; ?>">
<?php endif; ?>
    <div class="article-detail-text">
		<?= $model->description; ?>
    </div>
</section>
