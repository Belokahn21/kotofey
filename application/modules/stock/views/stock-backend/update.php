<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $model \app\modules\stock\models\entity\Stocks */

?>
<?php $this->title = Title::showTitle("Склады"); ?>
<section>
    <h1 class="title">Склад: <?= $model->name; ?></h1>
	<?= Html::a("Назад", ['index'], ['class' => 'btn-main']) ?>
	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
	<?= $this->render('_form', [
		'model' => $model,
		'form' => $form,
	]); ?>
	<?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
	<?php ActiveForm::end(); ?>
</section>