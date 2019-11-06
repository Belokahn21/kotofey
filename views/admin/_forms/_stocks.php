<?php

use yii\helpers\ArrayHelper;
use app\models\entity\Geo;

?>
<div class="tabs-container">
    <ul class="tabs">
        <li class="tab-link current" data-tab="tab-1">Основное</li>
        <li class="tab-link" data-tab="tab-2">Время работы</li>
    </ul>

    <div id="tab-1" class="tab-content current">
		<?= $form->field($model, 'name'); ?>
		<?= $form->field($model, 'address'); ?>
		<?= $form->field($model, 'sort')->textInput(['value' => 500]); ?>
		<?= $form->field($model, 'active')->checkbox(); ?>
		<?= $form->field($model, 'city_id')->dropDownList(ArrayHelper::map(Geo::find()->where(['type' => Geo::TYPE_OBJECT_CITY])->all(), 'id', 'name'), ['prompt' => 'Выбрать город']); ?>
    </div>
    <div id="tab-2" class="tab-content">
        <div style="display: flex">
            <div style="display:flex;">
				<?= $form->field($model, 'hour_start')->dropDownList(range(0, 23)); ?>
				<?= $form->field($model, 'minute_start')->dropDownList(range(0, 59)); ?>
            </div>
            <div style="display:flex; margin: 0 0 0 10%;">
				<?= $form->field($model, 'hour_end')->dropDownList(range(0, 23)); ?>
				<?= $form->field($model, 'minute_end')->dropDownList(range(0, 59)); ?>
            </div>
        </div>
    </div>
</div>