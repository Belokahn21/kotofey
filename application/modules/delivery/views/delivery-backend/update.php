<?php

/* @var $this yii\web\View */
/* @var $model app\modules\delivery\models\entity\Delivery */

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = Title::showTitle($model->name);
?>
<section class="delivery">
    <h1 class="title">Доставка: <?= $model->name; ?></h1>
<?php $form = ActiveForm::begin(); ?>
	<?= $this->render('_form', [
		'model' => $model,
		'form' => $form,
	]) ?>
	<?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>
</section>