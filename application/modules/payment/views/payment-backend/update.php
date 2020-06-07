<?php

/* @var $this yii\web\View */

/* @var $model \app\models\entity\Payment */

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Title::showTitle($model->name);
?>
<section class="payment">
    <h1 class="title">Оплата: <?= $model->name; ?></h1>
	<?= Html::a("Назад", Url::to(['index']), ['class' => 'btn-main']) ?>
	<?php $form = ActiveForm::begin(); ?>
	<?= $this->render('_form', [
		'model' => $model,
		'form' => $form,
	]) ?>
	<?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
	<?php ActiveForm::end(); ?>
</section>