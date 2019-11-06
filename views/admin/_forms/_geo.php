<?php

use yii\helpers\ArrayHelper;
use app\models\entity\GeoType;

/* @var $model \app\models\entity\Geo */
?>
<div class="tabs-container">
    <ul class="tabs">
        <li class="tab-link current" data-tab="tab-1">Основное</li>
    </ul>

    <div id="tab-1" class="tab-content current">
		<?= $form->field($model, 'name'); ?>
		<?= $form->field($model, 'type_id')->dropDownList(ArrayHelper::map(GeoType::find()->all(), 'id', 'name'), ['prompt' => 'Тип гео объекта']); ?>
    </div>
</div>