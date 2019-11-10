<?

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<? $form = ActiveForm::begin([
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
	'value' => $model->search,
	'placeholder' => 'Поиск товара'
])->label(false); ?>
<?= Html::submitButton('<i class="fas fa-search"></i>', ['class' => 'search-form__submit']) ?>
<? ActiveForm::end(); ?>