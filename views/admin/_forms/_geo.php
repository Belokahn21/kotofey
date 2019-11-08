<?php

/* @var $model \app\models\entity\Geo */
?>
<div class="tabs-container">
    <ul class="tabs">
        <li class="tab-link current" data-tab="tab-1">Основное</li>
    </ul>

    <div id="tab-1" class="tab-content current">
		<?= $form->field($model, 'name'); ?>
		<?= $form->field($model, 'active')->checkbox(); ?>
		<?= $form->field($model, 'sort')->textInput(['value'=>500]); ?>
		<?= $form->field($model, 'type')->dropDownList($model->getTypes(), ['prompt' => 'Тип гео объекта']); ?>
    </div>
</div>