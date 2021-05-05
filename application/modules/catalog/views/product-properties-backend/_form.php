<?php

use app\modules\catalog\models\entity\PropertyGroup;
use app\modules\catalog\models\entity\TypeProductProperties;
use yii\helpers\ArrayHelper;

/* @var $model \app\modules\catalog\models\entity\Properties */
/* @var $propertyGroup PropertyGroup */
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
            <div class="col-sm-4">
                <?= $form->field($model, 'is_show_site')->radioList(['Нет', 'Да']) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'is_multiple')->radioList(['Нет', 'Да']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <?= $form->field($model, 'name') ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'sort')->textInput(); ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'group_id')->dropDownList(ArrayHelper::map($propertyGroup, 'id', 'name'), ['prompt' => 'Группа свойства']); ?>
            </div>
        </div>
        <?= $form->field($model, 'type')->dropDownList((new TypeProductProperties())->listType(), ['prompt' => "Тип свойства", 'id' => 'select-type-prop']) ?>
    </div>
</div>
