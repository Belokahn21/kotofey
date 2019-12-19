<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin([
	'method' => 'get',
	'action' => '/search/',
	'options' => [
		'class' => 'search-form'
	]
]);
?>
<?= $form->field($model, 'search', [
	'template' => '{input}',
	'options' => [
		'tag' => false,
	]
])->textInput([
	'class' => 'search-form__query',
	'value' => Yii::$app->request->get('Search')['search'],
	'placeholder' => 'Поиск товара',
])->label(false); ?>
<?= Html::submitButton('<i class="fas fa-search"></i>', ['class' => 'search-form__submit']) ?>
<?php ActiveForm::end(); ?>