<?php

use app\models\entity\Sliders;
use yii\helpers\ArrayHelper;
/* @var $model \app\models\entity\SlidersImages */
?>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
        <!--		<a class="nav-item nav-link" id="nav-seo-tab" data-toggle="tab" href="#nav-seo" role="tab" aria-controls="nav-seo" aria-selected="false">SEO</a>-->
        <!--		<a class="nav-item nav-link" id="nav-gallery-tab" data-toggle="tab" href="#nav-gallery" role="tab" aria-controls="nav-gallery" aria-selected="false">Изображения</a>-->
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
		<?= $form->field($model, 'active')->radioList(['Нет', 'Да']); ?>
		<?= $form->field($model, 'slider_id')->dropDownList(ArrayHelper::map(Sliders::find()->all(), 'id', 'name'), ['prompt' => 'Слайдер']); ?>
        <div class="row">
            <div class="col-sm-6">
				<?= $form->field($model, 'start_at')->textInput(['class' => 'form-control js-datepicker']); ?>
            </div>
            <div class="col-sm-6">
				<?= $form->field($model, 'end_at')->textInput(['class' => 'form-control js-datepicker']); ?>
            </div>
        </div>
		<?= $form->field($model, 'text')->textInput(); ?>
		<?= $form->field($model, 'description')->textInput(); ?>
		<?= $form->field($model, 'sort')->textInput(); ?>
		<?= $form->field($model, 'link')->textInput(); ?>
		<?= $form->field($model, 'image')->fileInput(); ?>
    </div>
    <!--	<div class="tab-pane fade" id="nav-seo" role="tabpanel" aria-labelledby="nav-seo-tab">-->
    <!--	</div>-->
    <!--	<div class="tab-pane fade" id="nav-gallery" role="tabpanel" aria-labelledby="nav-gallery-tab">-->
    <!---->
    <!--	</div>-->
</div>