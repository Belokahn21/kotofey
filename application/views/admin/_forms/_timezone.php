<?php

use yii\helpers\ArrayHelper;

/* @var $model \app\models\entity\GeoTimezone */
?>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <?= $form->field($model, 'is_active')->checkbox(); ?>
        <?= $form->field($model, 'name')->textInput(); ?>
        <?= $form->field($model, 'value')->textInput(); ?>
        <?= $form->field($model, 'sort')->textInput(['value' => 500]); ?>
    </div>
</div>