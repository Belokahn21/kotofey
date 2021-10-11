<?php
/* @var $this \yii\web\View
 * @var $model \app\modules\media\models\entity\Media
 */

use yii\helpers\Url;
use yii\helpers\Html;
use app\modules\media\models\entity\Media;

$this->title = \app\modules\seo\models\tools\Title::show($model->name);
?>

<div class="title-group">
    <h1><?= $model->name; ?></h1>
    <?= Html::a('Назад', Url::to(['index']), ['class' => 'btn-main']); ?>
    <?= Html::a('Удалить', Url::to(['delete', 'id' => $model->id]), ['class' => 'btn-main']); ?>
</div>
<?php if ($model->location == Media::LOCATION_CDN): ?>
    <?php $image_path = $model->cdnData['secure_url']; ?>
<?php else: ?>
    <?php $image_path = '/upload/' . $model->path; ?>
<?php endif; ?>
<a href="<?= $image_path; ?>" data-lightbox="roadtrip">
    <img src="<?= $image_path; ?>" width="200" class="m-5">
</a>
