<?php

use yii\helpers\ArrayHelper;

/* @var $model \app\modules\geo\models\entity\Geo */
/* @var $time_zones \app\modules\geo\models\entity\GeoTimezone[] */
?>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="row">
            <div class="col-sm-6">
				<?= $form->field($model, 'active')->checkbox(); ?>
            </div>
            <div class="col-sm-6">
				<?= $form->field($model, 'is_default')->checkbox(); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
				<?= $form->field($model, 'name'); ?>
            </div>
            <div class="col-6">
				<?= $form->field($model, 'address'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
				<?= $form->field($model, 'start_at')->textInput(['class' => 'form-control js-datepicker']); ?>
            </div>
            <div class="col-6">
				<?= $form->field($model, 'end_at')->textInput(['class' => 'form-control js-datepicker']); ?>
            </div>
        </div>
		<?= $form->field($model, 'sort')->textInput(['value' => 500]); ?>
		<?= $form->field($model, 'type')->dropDownList($model->getTypes(), ['prompt' => 'Тип гео объекта']); ?>
		<?= $form->field($model, 'time_zone_id')->dropDownList(ArrayHelper::map($time_zones, 'id', 'name'), ['prompt' => 'Временная зона']); ?>
    </div>
</div>