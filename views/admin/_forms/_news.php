<?php

use yii\helpers\ArrayHelper;
use app\models\entity\NewsCategory;
use mihaildev\ckeditor\CKEditor;

/* @var $model \app\models\entity\News */

?>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
        <a class="nav-item nav-link" id="nav-seo-tab" data-toggle="tab" href="#nav-seo" role="tab" aria-controls="nav-seo" aria-selected="false">SEO</a>
        <a class="nav-item nav-link" id="nav-preview-tab" data-toggle="tab" href="#nav-preview" role="tab" aria-controls="nav-preview" aria-selected="false">Краткий обзор</a>
        <a class="nav-item nav-link" id="nav-detail-tab" data-toggle="tab" href="#nav-detail" role="tab" aria-controls="nav-detail" aria-selected="false">Детальный обзор</a>
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="form-element">
            <?= $form->field($model, 'is_active')->checkbox(); ?>
        </div>
        <div class="form-element">
            <?= $form->field($model, 'title'); ?>
        </div>
        <div class="form-element">
            <?= $form->field($model, 'category')->dropDownList(ArrayHelper::map(NewsCategory::find()->all(), 'id', 'name'), ['prompt' => 'Выбрать рубрику']); ?>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-seo" role="tabpanel" aria-labelledby="nav-seo-tab">
        <div class="form-element">
            <?= $form->field($model, 'seo_keywords')->textInput(); ?>
        </div>
        <div class="form-element">
            <?= $form->field($model, 'seo_description')->textarea(); ?>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-preview" role="tabpanel" aria-labelledby="nav-preview-tab">
        <?php if (!empty($model->preview_image)): ?>
            <div>
                <img src="/upload/<?= $model->preview_image; ?>">
            </div>
        <?php endif; ?>
        <?= $form->field($model, 'preview_image')->fileInput(); ?>
        <?= $form->field($model, 'preview')->widget(CKEditor::className(), [
            'editorOptions' => [
                'preset' => 'full',
                'inline' => false,
            ],
        ]); ?>
    </div>
    <div class="tab-pane fade" id="nav-detail" role="tabpanel" aria-labelledby="nav-detail-tab">
        <?php if (!empty($model->detail_image)): ?>
            <div>
                <img src="/upload/<?= $model->detail_image; ?>">
            </div>
        <?php endif; ?>
        <?= $form->field($model, 'detail_image')->fileInput(); ?>
        <?= $form->field($model, 'detail')->widget(CKEditor::className(), [
            'editorOptions' => [
                'preset' => 'full',
                'inline' => false,
            ],
        ]); ?>
    </div>
</div>