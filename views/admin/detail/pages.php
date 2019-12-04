<?php

use yii\helpers\ArrayHelper;
use app\models\entity\NewsCategory;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\tool\seo\Title;
use mihaildev\ckeditor\CKEditor;

/* @var $model \app\models\entity\News */

$this->title = Title::showTitle($model->title);
?>
<section>
    <h1 class="title">Новостная запись: <?= $model->title ?></h1>
    <div class="clearfix"></div>
    <?= Html::a("Просмотр новости", $model->detailurl, ['target' => '_blank']); ?>
    <div class="clearfix"></div>
    <div class="product-form">
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="tabs-container">
            <ul class="tabs">
                <li class="tab-link current" data-tab="tab-1">Основное</li>
                <li class="tab-link" data-tab="tab-2">Краткий обзор</li>
                <li class="tab-link" data-tab="tab-3">Дательное описание</li>
                <li class="tab-link" data-tab="tab-4">SEO</li>
            </ul>

            <div id="tab-1" class="tab-content current">
                <?= $form->field($model, 'title'); ?>
                <?= $form->field($model, 'category')->dropDownList(ArrayHelper::map(NewsCategory::find()->all(), 'id',
                    'name'), ['prompt' => 'Выбрать рубрику']); ?>
            </div>
            <div id="tab-2" class="tab-content">
                <div>
                    <img src="<?= $model->preview_image; ?>" width="200px;">
                </div>
                <?= $form->field($model, 'preview_image')->fileInput(); ?>
                <?= $form->field($model, 'preview')->widget(CKEditor::className(),[
                    'editorOptions' => [
                        'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
                        'inline' => false, //по умолчанию false
                    ],
                ]); ?>
            </div>
            <div id="tab-3" class="tab-content">
                <div>
                    <img src="<?= $model->detail_image; ?>" width="200px;">
                </div>
                <?= $form->field($model, 'detail_image')->fileInput(); ?>
                <?= $form->field($model, 'detail')->widget(CKEditor::className(),[
                    'editorOptions' => [
                        'preset' => 'full',
                        'inline' => false,
                    ],
                ]); ?>
            </div>
            <div id="tab-4" class="tab-content">
                <?= $form->field($model, 'seo_keywords')->textInput(); ?>
                <?= $form->field($model, 'seo_description')->textarea(); ?>
            </div>
            <?= Html::submitButton('Обновить'); ?>
<?php ActiveForm::end(); ?>
        </div>
</section>