<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this \yii\web\View */

$this->title = Title::showTitle('Товары');
?>

<?php $form = ActiveForm::begin(); ?>
<?= $this->render('_form', [
	'model' => $model,
	'form' => $form
]) ?>
<?= Html::submitButton('Добавить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>
