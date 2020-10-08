<?php

/* @var $model \app\modules\promocode\models\entity\Promocode
 * @var $form  \yii\widgets\ActiveForm
 */

?>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="form-element">
            <?= $form->field($model, 'infinity')->checkbox(); ?>
        </div>
        <div class="form-element">
            <?= $form->field($model, 'code')->textInput(['placeholder' => 'Промокод'])->label(false); ?>
        </div>
        <div class="form-element">
            <?= $form->field($model, 'discount')->textInput(['placeholder' => 'Скидка (-%)'])->label(false); ?>
        </div>
        <div class="form-element">
            <?= $form->field($model, 'count')->textInput(['placeholder' => 'Количество'])->label(false); ?>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'start_at')->textInput(['class' => 'form-control js-datepicker']); ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'end_at')->textInput(['class' => 'form-control js-datepicker']); ?>
            </div>
        </div>
    </div>
</div>