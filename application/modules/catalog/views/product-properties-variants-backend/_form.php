<?php

use yii\helpers\ArrayHelper;
use app\modules\catalog\models\entity\Properties;
use app\modules\media\widgets\MediaBrowser\MediaBrowserWidget;

/* @var $model \app\modules\catalog\models\entity\PropertiesVariants
 * @var $form \yii\widgets\ActiveForm
 */

?>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
        <a class="nav-item nav-link " id="nav-content-tab" data-toggle="tab" href="#nav-content" role="tab" aria-controls="nav-content" aria-selected="true">Контент</a>
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'is_active')->checkbox(); ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'property_id')->dropDownList(ArrayHelper::map(Properties::find()->all(), 'id', 'name'), ['prompt' => 'Справочник']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'name')->textInput(); ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'slug')->textInput(); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'sort')->textInput(['value' => 500]) ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'link')->textInput(); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php
                $media_params = [];
                if ($model->media) {
                    $media_params = [
                        'values' => [$model->media_id]
                    ];
                }
                echo $form->field($model, 'media_id')->widget(MediaBrowserWidget::className(), $media_params);
                ?>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-content" role="tabpanel" aria-labelledby="nav-content-tab">
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'view')->textInput() ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'text')->textarea() ?>
            </div>
        </div>
    </div>
</div>