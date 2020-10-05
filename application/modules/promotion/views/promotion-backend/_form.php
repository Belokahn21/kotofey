<?php
/* @var $form \yii\widgets\ActiveForm
 * @var $model \app\modules\promotion\models\entity\Promotion
 * @var $sliderImagesModel \app\modules\content\models\entity\SlidersImages
 */
?>


<nav>
    <div class="nav nav-tabs" id="backendForms" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
        <a class="nav-item nav-link" id="nav-slider-tab" data-toggle="tab" href="#nav-slider" role="tab" aria-controls="nav-home" aria-selected="true">Слайдер</a>
    </div>
</nav>
<div class="tab-content" id="backendFormsContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="form-element">
            <?= $form->field($model, 'name') ?>
        </div>

        <div class="row">
            <div class="form-element col-sm-6">
                <?= $form->field($model, 'start_at')->textInput(['class' => 'form-control js-datepicker']); ?>
            </div>
            <div class="form-element col-sm-6">
                <?= $form->field($model, 'end_at')->textInput(['class' => 'form-control js-datepicker']); ?>
            </div>
        </div>
    </div>
    <div class="tab-pane" id="nav-slider" role="tabpanel" aria-labelledby="nav-slider-tab">
        <?= $this->render('@app/modules/content/views/slider-images-backend/_form', [
            'form' => $form,
            'model' => $sliderImagesModel
        ]); ?>
    </div>
</div>