<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\entity\Sliders;
use yii\helpers\Url;

/* @var \app\models\entity\SlidersImages $model */
/* @var \yii\web\View $this */

$this->title = Title::showTitle($model->text); ?>
<section>
    <h1 class="title"><?php echo $model->text; ?></h1>
	<?= Html::a("Назад", Url::to(['admin/sliderimages']), ['class' => 'btn-main']) ?>
    <div class="clearfix"></div>
    <div class="product-form">
		<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
		<?= $this->render('../_forms/_slider-images', [
			'form' => $form,
			'model' => $model
		]) ?>
		<?php echo Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
		<?php ActiveForm::end(); ?>
    </div>
</section>
