<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var \app\modules\content\models\entity\Sliders $model */
/* @var \yii\web\View $this */

$this->title = Title::showTitle("Слайдер: " . $model->name); ?>
<section>
    <h1 class="title">Слайдер: <?= $model->name; ?></h1>
	<?= Html::a('Назад', Url::to(['index']), ['class' => 'btn-main']) ?>
    <div class="product-form">
		<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
		<?= $this->render('_form', [
			'form' => $form,
			'model' => $model
		]); ?>
		<?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
		<?php ActiveForm::end(); ?>
    </div>
</section>
