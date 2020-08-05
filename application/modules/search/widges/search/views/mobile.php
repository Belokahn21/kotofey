<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<?php $form = ActiveForm::begin([
	'options' => [
		'class' => 'mobile-search js-search-form',
	],
	'action' => \yii\helpers\Url::to(['search']),
	'method' => 'get',
	'fieldConfig' => [
		'options' => [
			'tag' => false,
		],
	],
]);
?>


<?= $form->field($model, 'search')->textInput([
	'class' => 'mobile-search__input',
	'placeholder' => 'Найти товар',
	'value' => $model->search
])->label(false) ?>

<?= Html::submitButton('<i class="fas fa-search"></i>', [
	'class' => 'mobile-search__submit mobile-search__control'
]); ?>

<?= Html::button('<i class="fas fa-times"></i>', [
	'class' => 'mobile-search__close mobile-search__control js-search-toggle'
]) ?>

<?php ActiveForm::end(); ?>