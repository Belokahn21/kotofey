<?php
/* @var $form \yii\widgets\ActiveForm
 * @var $model \app\modules\pets\models\entity\Animal
 */

use app\modules\media\widgets\MediaBrowser\MediaBrowserWidget;

?>

<nav>
    <div class="nav nav-tabs" id="backendForms" role="tablist">
        <a class="nav-item nav-link active" id="nav-main-edit-tab" data-toggle="tab" href="#nav-main-edit" role="tab" aria-controls="nav-main-edit" aria-selected="false">Главное</a>
    </div>
</nav>
<div class="tab-content" id="backendFormsContent">
    <div class="tab-pane fade show active" id="nav-main-edit" role="tabpanel" aria-labelledby="nav-main-edit">
        <div class="row">
            <div class="col-sm-12">
                <?= $form->field($model, 'is_active')->checkbox(); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4"><?= $form->field($model, 'name'); ?></div>
            <div class="col-sm-4"><?= $form->field($model, 'icon'); ?></div>
            <div class="col-sm-4"><?= $form->field($model, 'sort')->textInput(['value' => 500]); ?></div>
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
</div>