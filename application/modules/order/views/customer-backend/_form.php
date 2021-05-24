<?php

/* @var $model \app\modules\catalog\models\entity\Properties */
/* @var $properties \app\modules\order\models\entity\CustomerProperties[] */
/* @var $form \yii\widgets\ActiveForm */

?>

<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'is_active')->radioList(['Нет', 'Да']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'name') ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'sort')->textInput(); ?>
            </div>
        </div>

<!--        --><?php //foreach ($properties as $property): ?>
<!--            --><?//= $form->field($propertiesValues, 'property_id')->hiddenInput(['value' => $property->id]); ?>
<!--        --><?php //endforeach; ?>
    </div>
</div>
