<?php

/* @var $model \app\models\entity\Informers */

?>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

        <div class="row">
            <div class="col-sm-6">
                <div class="form-element">
                    <?= $form->field($model, 'is_active')->checkbox(); ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-element">
                    <?= $form->field($model, 'is_show_filter')->checkbox(); ?>
                </div>
            </div>
        </div>

        <div class="form-element">
            <?= $form->field($model, 'name') ?>
        </div>

        <div class="form-element">
            <?= $form->field($model, 'sort')->textInput() ?>
        </div>

        <div class="form-element">
            <?= $form->field($model, 'description')->textarea(); ?>
        </div>
    </div>
</div>
