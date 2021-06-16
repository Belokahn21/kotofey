<?php

use mihaildev\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;

/* @var $events \app\modules\mailer\models\entity\MailEvents[] */
/* @var $model \app\modules\mailer\models\entity\MailTemplates */
/* @var $form \yii\widgets\ActiveForm */

?>
<nav>
    <div class="nav nav-tabs" id="backendForms" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
    </div>
</nav>
<div class="tab-content" id="backendFormsContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="row">
            <div class="col-sm-4">
                <div class="form-element">
                    <?= $form->field($model, 'event_id')->dropDownList(ArrayHelper::map($events, 'id', 'name'), ['prompt' => 'Почтовое событие'])->label(false); ?>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-element">
                    <?= $form->field($model, 'name')->textInput(['placeholder' => 'Название письма'])->label(false); ?>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-element">
                    <?= $form->field($model, 'code')->textInput(['placeholder' => 'Символьный код'])->label(false); ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <?= $form->field($model, 'from')->textInput(['placeholder' => 'Отправитель'])->label(false); ?>
            </div>
            <div class="col-6">
                <?= $form->field($model, 'to')->textInput(['placeholder' => 'Получатели(через запятую)'])->label(false); ?>
            </div>
        </div>

        <?php /*= $form->field($model, 'text')->widget(CKEditor::className(), [
            'editorOptions' => [
                'preset' => 'full',
                'inline' => false
            ]
        ]); */ ?>

        <?= $form->field($model, 'text')->textarea(['rows' => 10]); ?>

    </div>
</div>