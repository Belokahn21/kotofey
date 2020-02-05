<?php

use app\models\entity\Sliders;
use yii\helpers\ArrayHelper;

/* @var $model \app\models\entity\SlidersImages */
?>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="form-element">
			<?= $form->field($model, 'text')->textInput(); ?>
        </div>

        <div class="form-element">
			<?= $form->field($model, 'link')->textInput(); ?>
        </div>

        <div class="form-element">
            <div class="row">
                <div class="col-sm-2">
					<?= $form->field($model, 'active')->radioList(['Нет', 'Да']); ?>
                </div>
                <div class="col-sm-1">
					<?= $form->field($model, 'sort')->textInput(); ?>
                </div>
                <div class="col-sm-3">
					<?= $form->field($model, 'slider_id')->dropDownList(ArrayHelper::map(Sliders::find()->all(), 'id', 'name'), ['prompt' => 'Слайдер']); ?>
                </div>
                <div class="col-sm-3">
					<?= $form->field($model, 'start_at')->textInput(['class' => 'form-control js-datepicker']); ?>
                </div>
                <div class="col-sm-3">
					<?= $form->field($model, 'end_at')->textInput(['class' => 'form-control js-datepicker']); ?>
                </div>
            </div>
        </div>

        <div class="form-element">
			<?= $form->field($model, 'description')->textarea(); ?>
        </div>

        <div class="form-element">
			<?= $form->field($model, 'image')->fileInput(); ?>
        </div>
    </div>
</div>