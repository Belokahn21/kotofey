<?php

/* @var $this yii\web\View */
/* @var $model \app\models\entity\Delivery */

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Title::showTitle($model->name);
?>
<section class="delivery">
    <h1 class="title">Доставка: <?= $model->name; ?></h1>
<?php $form = ActiveForm::begin(); ?>
	<?= $this->render('../_forms/_delivery', [
		'model' => $model,
		'form' => $form,
	]) ?>
	<?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>
</section>