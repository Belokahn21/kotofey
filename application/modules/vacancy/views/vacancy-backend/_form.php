<?php

use yii\helpers\ArrayHelper;

/* @var $this \yii\web\View */
/* @var $city_list \app\modules\geo\models\entity\Geo[] */

?>
<?= $form->field($model, 'city_id')->dropDownList(ArrayHelper::map($city_list, 'id', 'name'), ['prompt' => 'Выбрать город']); ?>
<?= $form->field($model, 'title')->textInput(); ?>
<?= $form->field($model, 'sort')->textInput(['value' => 500]); ?>
<?= $form->field($model, 'is_active')->checkbox(); ?>
<?= $form->field($model, 'description')->textarea(); ?>
<?= $form->field($model, 'price')->textInput(); ?>
<?= $form->field($model, 'image')->fileInput(); ?>
