<?php

/* @var $model \app\modules\delivery\models\entity\DeliveryService
 * @var $form \yii\widgets\ActiveForm
 */

?>
<nav>
    <div class="nav nav-tabs" id="backendForms" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
    </div>
</nav>
<div class="tab-content" id="backendFormsContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="row">
            <div class="col-4"><?= $form->field($model, 'name')->textInput(); ?></div>
            <div class="col-4"><?= $form->field($model, 'code')->textInput(); ?></div>
            <div class="col-4"><?= $form->field($model, 'sort')->textInput(); ?></div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'is_active')->checkbox() ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'description')->textarea(); ?>
            </div>
        </div>
    </div>
</div>

