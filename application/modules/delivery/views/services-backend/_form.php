<?php

/* @var $model \app\modules\delivery\models\entity\DeliveryService
 * @var $form \yii\widgets\ActiveForm
 */

use app\modules\media\widgets\MediaBrowser\MediaBrowserWidget;

?>
<nav>
    <div class="nav nav-tabs" id="backendForms" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
    </div>
</nav>
<div class="tab-content" id="backendFormsContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="row">
            <div class="col-4"><?= $form->field($model, 'name')->textInput(); ?></div>
            <div class="col-4"><?= $form->field($model, 'code')->textInput(); ?></div>
            <div class="col-4"><?= $form->field($model, 'sort')->textInput(); ?></div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'is_active')->checkbox() ?>
            </div>
            <div class="col-sm-6">
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
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'description')->textarea(); ?>
            </div>
        </div>
    </div>
</div>

