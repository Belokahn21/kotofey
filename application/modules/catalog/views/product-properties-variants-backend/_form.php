<?php

use yii\helpers\ArrayHelper;
use app\modules\catalog\models\entity\SaveInformers;
use app\modules\media\widgets\InputUploadWidget\InputUploadWidget;

/* @var $model \app\modules\catalog\models\entity\SaveInformersValues */

?>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <?= $form->field($model, 'name')->textInput() ?>
        <?= $form->field($model, 'is_active')->checkbox() ?>
        <?= $form->field($model, 'property_id')->dropDownList(ArrayHelper::map(SaveInformers::find()->all(), 'id', 'name'), ['prompt' => 'Справочник']) ?>
        <?= $form->field($model, 'sort')->textInput(['value' => 500]) ?>
        <?= $form->field($model, 'link')->textInput() ?>

    </div>
</div>