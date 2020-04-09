<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $sliderImageModel \app\models\entity\SlidersImages */
?>
<?php
$this->title = Title::showTitle("Запустить промоакцию");
?>
    <h1>Запустить промоакцию</h1>
<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'discount')->textInput(); ?>
<?= $form->field($model, 'product_id')->textarea(['rows' => 10]); ?>
    <div class="d-flex flex-column">
        <div class="w-100 my-5">
            <?= $this->render('@app/views/admin/_forms/_slider-images', [
                'form' => $form,
                'model' => $sliderImageModel
            ]); ?>
        </div>
        <div class="w-100 my-5">
            <?= $this->render('@app/views/admin/_forms/_informers-values', [
                'form' => $form,
                'model' => $informerValuesForm
            ]); ?>
        </div>
    </div>
<?= Html::submitButton('Создать', ['class' => 'btn-main']) ?>
<?php ActiveForm::end();
