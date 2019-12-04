<?php

use app\models\entity\UserSex;
use yii\helpers\ArrayHelper;

/* @var $model \app\models\entity\User */

?>

<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Основное</a>
        <a class="nav-item nav-link" id="nav-additional-tab" data-toggle="tab" href="#nav-additional" role="tab" aria-controls="nav-additional" aria-selected="false">Дополнительно</a>
        <a class="nav-item nav-link" id="nav-gallery-tab" data-toggle="tab" href="#nav-gallery" role="tab" aria-controls="nav-gallery" aria-selected="false">Изображения</a>
    </div>
</nav>
<div class="tab-content" id="nav-tab-content-form">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="row">
            <div class="col-sm-6">
				<?= $form->field($model, 'email'); ?>
				<?= $form->field($model, 'phone'); ?>
				<?= $form->field($model, 'new_password')->passwordInput(); ?>
            </div>
            <div class="col-sm-6">
				<?php if (is_object($model->group)): ?>
					<?php $model->groups = $model->group->name; ?>
				<?php endif ?>
				<?= $form->field($model, 'groups')->dropDownList(ArrayHelper::map($groups, 'name', 'name'), ['prompt' => 'Выбрать группу']); ?>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-additional" role="tabpanel" aria-labelledby="nav-additional-tab">
		<?= $form->field($model, 'first_name'); ?>
		<?= $form->field($model, 'name'); ?>
		<?= $form->field($model, 'last_name'); ?>
		<?= $form->field($model, 'birthday')->textInput(); ?>
		<?= $form->field($model, 'sex')->dropDownList(ArrayHelper::map(UserSex::find()->all(), 'id', 'name'), ['prompt' => 'Выбрать пол']); ?>
    </div>
    <div class="tab-pane fade" id="nav-gallery" role="tabpanel" aria-labelledby="nav-gallery-tab">
		<?= $form->field($model, 'avatar')->fileInput(); ?>
    </div>
</div>
