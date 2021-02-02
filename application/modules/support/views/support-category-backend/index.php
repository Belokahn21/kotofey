<?php

use app\modules\seo\models\tools\Title;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Title::show("Разделы технической поддержки"); ?>
<section>
    <h1 class="title">Разделы</h1>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name'); ?>
    <?= $form->field($model, 'description')->textarea(); ?>
    <?= $form->field($model, 'sort'); ?>
    <?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
    <?php ActiveForm::end(); ?>
</section>

