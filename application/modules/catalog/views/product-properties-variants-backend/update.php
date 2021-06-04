<?php

use app\modules\seo\models\tools\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this \yii\web\View */
$this->title = Title::show($model->name); ?>
<section>
    <h1 class="title">Значение справочника: <?= $model->name; ?></h1>
    <?= Html::a("Назад", \yii\helpers\Url::to(['index']), ['class' => 'btn-main']) ?>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $this->render('_form', [
        'form' => $form,
        'model' => $model,
    ]) ?>
    <?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
    <?php ActiveForm::end(); ?>
</section>