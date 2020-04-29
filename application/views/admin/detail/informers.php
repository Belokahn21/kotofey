<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = Title::showTitle("Справочники"); ?>
<section>
    <h1 class="title">Справочник: <?= $model->name; ?></h1>
	<?= Html::a("Назад", Url::to(['admin/informers']), ['class' => 'btn-main']) ?>
	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart / form - data']]); ?>
	<?= $this->render('../_forms/_informers', [
		'model' => $model,
		'form' => $form,
	]); ?>
	<?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
	<?php ActiveForm::end(); ?>
</section>
