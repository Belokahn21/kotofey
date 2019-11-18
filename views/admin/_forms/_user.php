<?php

use app\models\entity\UserSex;
use yii\helpers\ArrayHelper;

/* @var $model \app\models\entity\User */

?>
<div class="tabs-container">
    <ul class="tabs">
        <li class="tab-link current" data-tab="tab-1">Основное</li>
        <li class="tab-link" data-tab="tab-2">Аватар</li>
        <li class="tab-link" data-tab="tab-3">Разрешения</li>
        <li class="tab-link" data-tab="tab-4">Расширенное</li>
    </ul>

    <div id="tab-1" class="tab-content current">
        <?= $form->field($model, 'email'); ?>
        <?= $form->field($model, 'phone'); ?>
        <?= $form->field($model, 'new_password')->passwordInput(); ?>
    </div>
    <div id="tab-2" class="tab-content">
        <?= $form->field($model, 'avatar')->fileInput(); ?>
    </div>
    <div id="tab-3" class="tab-content">
        <h2>Разрешения</h2>
        <?php $model->groups = $model->group->name; ?>
        <?= $form->field($model, 'groups')->dropDownList(ArrayHelper::map($groups, 'name', 'name'), ['prompt' => 'Выбрать группу']); ?>
        <div class="clearfix"></div>
    </div>
    <div id="tab-4" class="tab-content">
        <?= $form->field($model, 'first_name'); ?>
        <?= $form->field($model, 'name'); ?>
        <?= $form->field($model, 'last_name'); ?>
        <?= $form->field($model, 'birthday')->textInput(); ?>
        <?= $form->field($model, 'sex')->dropDownList(ArrayHelper::map(UserSex::find()->all(), 'id', 'name'), ['prompt' => 'Выбрать пол']); ?>
        <div class="clearfix"></div>
    </div>
</div>