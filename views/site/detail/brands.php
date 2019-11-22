<?
/* @var $this yii\web\View */

/* @var $model \app\models\entity\InformersValues */

use app\models\tool\seo\Title;

$this->params['breadcrumbs'][] = ['label' => 'Бренды', 'url' => ['/brands/']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['/brands/' . $model->id . '/']];
$this->title = Title::showTitle($model->name);
?>

<section class="article-detail">
    <h1 class="article-detail__title"><?= $model->name; ?></h1>
	<? if (!empty($model->detail_image)): ?>
        <img class="article-detail-image" src="<?= $model->detail_image; ?>" alt="<?= $model->name ?>" title="<?= $model->name; ?>">
	<? endif; ?>
    <div class="article-detail-text">
		<?= $model->description; ?>
    </div>
</section>
