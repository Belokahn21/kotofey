<?php

use app\modules\catalog\models\entity\TypeProductProperties;
use yii\helpers\ArrayHelper;
use app\modules\catalog\models\entity\SaveInformers;

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
                <?= $form->field($model, 'active')->radioList(['Нет', 'Да']) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'need_show')->radioList(['Нет', 'Да']) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($model, 'multiple')->radioList(['Нет', 'Да']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'name') ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'sort')->textInput() ?>
            </div>
        </div>

        <?php if (Yii::$app->request->get('type')) {
            $model->type = Yii::$app->request->get('type');
        } ?>

        <?= $form->field($model, 'type')->dropDownList((new TypeProductProperties())->listType(), ['prompt' => "Тип свойства", 'id' => 'select-type-prop']) ?>
        <?php if (Yii::$app->request->get('type') == "1"): ?>
            <?= $form->field($model, 'informer_id')->dropDownList(ArrayHelper::map(SaveInformers::find()->all(), 'id', 'name'), ['prompt' => 'Справочник']) ?>
        <?php endif; ?>
    </div>
</div>
