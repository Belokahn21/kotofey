<?php

use app\models\rbac\AuthItem;
use yii\helpers\ArrayHelper;

?>
<div class="tabs-container">
    <ul class="tabs">
        <li class="tab-link current" data-tab="tab-1">Основное</li>
    </ul>
    <div id="tab-1" class="tab-content current">
        <?= $form->field($model, 'name')->textInput(); ?>
        <?= $form->field($model, 'parent')->dropDownList(ArrayHelper::map((new AuthItem())->threeGroups(), 'name', 'format_name'), ['prompt' => 'Родительская группа']); ?>
        <?= $form->field($model, 'description')->textInput(); ?>
    </div>
</div>