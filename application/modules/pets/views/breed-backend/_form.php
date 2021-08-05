<?php

use yii\helpers\ArrayHelper;

/* @var $model \app\modules\pets\models\entity\Breed */
/* @var $form \yii\widgets\ActiveForm */
/* @var $animals \yii\helpers\ArrayHelper */
?>
<nav>
    <div class="nav nav-tabs" id="backendForms" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
    </div>
</nav>
<div class="tab-content" id="backendFormsContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="row">
            <div class="col-sm-12"><?= $form->field($model, 'is_active')->checkbox(); ?></div>
        </div>
        <div class="row">
            <div class="col-sm-4"><?= $form->field($model, 'sort'); ?></div>
            <div class="col-sm-4"><?= $form->field($model, 'name'); ?></div>
            <div class="col-sm-4"><?= $form->field($model, 'animal_id')->dropDownList(ArrayHelper::map($animals, 'id', 'name'), ['prompt' => 'Выбрать животное']); ?></div>
        </div>
    </div>
</div>