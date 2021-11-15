<?php

use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $categories \app\modules\catalog\models\entity\ProductCategory[] */
/* @var $model \app\modules\catalog\models\entity\ProductCategory */

?>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
        <a class="nav-item nav-link" id="nav-seo-tab" data-toggle="tab" href="#nav-seo" role="tab" aria-controls="nav-seo" aria-selected="false">SEO</a>
        <a class="nav-item nav-link" id="nav-gallery-tab" data-toggle="tab" href="#nav-gallery" role="tab" aria-controls="nav-gallery" aria-selected="false">Изображения</a>
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'name'); ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'sort'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'parent_category_id')->dropDownList(ArrayHelper::map($categories, 'id', 'name'), ['prompt' => 'Родительская категория']); ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'ozon_id'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'description')->widget(CKEditor::className(), [
                    'editorOptions' => [
                        'preset' => 'full',
                        'inline' => false
                    ]
                ]); ?>
            </div>
        </div>


    </div>
    <div class="tab-pane fade" id="nav-seo" role="tabpanel" aria-labelledby="nav-seo-tab">
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'seo_title'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'seo_keywords'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'seo_description'); ?>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-gallery" role="tabpanel" aria-labelledby="nav-gallery-tab">

        <?php if ($model->image): ?>
            <?= Html::img('/upload/' . $model->image, ['width' => 200]); ?>
        <?php endif; ?>
        <?= $form->field($model, 'image')->fileInput(); ?>
    </div>
</div>