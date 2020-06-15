<?php

use yii\helpers\ArrayHelper;
use app\models\entity\NewsCategory;
use mihaildev\ckeditor\CKEditor;

/* @var $model \app\models\entity\NewsCategory */

?>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="form-element">
            <?= $form->field($model, 'name'); ?>
        </div>
        <div class="form-element">
            <?= $form->field($model, 'sort'); ?>
        </div>
        <div class="form-element">
            <?= $form->field($model, 'parent')->dropDownList(ArrayHelper::map(NewsCategory::find()->all(), 'id', 'name'), ['prompt' => 'Выбрать родительский раздел']); ?>
        </div>
    </div>
</div>