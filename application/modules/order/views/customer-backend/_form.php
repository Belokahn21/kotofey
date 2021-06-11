<?php

use app\modules\order\models\entity\CustomerPropertiesValues;

/* @var $model \app\modules\order\models\entity\Customer */
/* @var $properties \app\modules\order\models\entity\CustomerProperties[] */
/* @var $propertiesValues \app\modules\order\models\entity\CustomerPropertiesValues */
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
            <div class="col-12 col-sm-3">
                <?= $form->field($model, 'is_active')->radioList(['Нет', 'Да']) ?>
            </div>
            <div class="col-12 col-sm-3">
                <?= $form->field($model, 'phone') ?>
            </div>
            <div class="col-12 col-sm-3">
                <?= $form->field($model, 'name') ?>
            </div>
            <div class="col-12 col-sm-3">
                <?= $form->field($model, 'sort')->textInput(); ?>
            </div>
        </div>

        <br>
        <hr>
        <h4>Свойства</h4>
        <?php
        $count = 1;
        foreach ($properties as $property) {
            if ($count % 4 == 1) {
                echo "<div class='row'>";
            } ?>

            <div class="col-3">
                <?= $form->field($propertiesValues, '[' . $count - 1 . ']property_id')->hiddenInput(['value' => $property->id])->label(false); ?>


                <?php if ($model->isNewRecord): ?>
                    <?= $form->field($propertiesValues, '[' . $count - 1 . ']value')->textInput()->label($property->name); ?>
                <?php else: ?>
                    <?php $value = CustomerPropertiesValues::findOne(['customer_id' => $model->phone, 'property_id' => $property->id]); ?>
                    <?= $form->field($propertiesValues, '[' . $count - 1 . ']value')->textInput(['value' => $value ? $value->value : false])->label($property->name); ?>
                <?php endif; ?>
            </div>


            <?php if ($count % 4 == 0) {
                echo "</div>";
            }
            $count++;
        }
        if ($count % 4 != 1) echo "</div>"; ?>


    </div>
</div>
