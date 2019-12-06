<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\tool\seo\Title;
use yii\helpers\Url;

/* @var $model \app\models\entity\News */

$this->title = Title::showTitle($model->title);
?>
<section>
    <h1 class="title">Новостная запись: <?= $model->title ?></h1>
	<?= Html::a("Назад", Url::to(['admin/news']), ['class' => 'btn-main']); ?>
	<?= Html::a("Просмотр новости", $model->detailurl, ['target' => '_blank', 'class' => 'btn-main']); ?>
	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<?= $this->render('../_forms/_news', [
		'form' => $form,
		'model' => $model,
	]); ?>
	<?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
	<?php ActiveForm:: end(); ?>
</section>