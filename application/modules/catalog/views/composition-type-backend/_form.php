<?php

/* @var $model \app\modules\catalog\models\entity\CompositionType
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
            <div class="col-3">
                <?= $form->field($model, 'is_active'); ?>
            </div>
            <div class="col-3">
                <?= $form->field($model, 'name'); ?>
            </div>
            <div class="col-3">
                <?= $form->field($model, 'sort'); ?>
            </div>
            <div class="col-3">

            </div>
        </div>
    </div>
</div>