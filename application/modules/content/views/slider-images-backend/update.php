<?php

use app\modules\seo\models\tools\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var \app\modules\content\models\entity\SlidersImages $model */
/* @var \yii\web\View $this */

$this->title = Title::show($model->text); ?>
<section>
    <h1 class="title"><?php echo $model->text; ?></h1>
	<?= Html::a("Назад", Url::to(['index']), ['class' => 'btn-main']) ?>
    <div class="clearfix"></div>
    <div class="product-form">
		<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
		<?= $this->render('_form', [
			'form' => $form,
			'model' => $model
		]) ?>
		<?php echo Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
		<?php ActiveForm::end(); ?>
    </div>
</section>
