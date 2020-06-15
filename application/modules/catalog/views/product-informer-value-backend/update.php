<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\entity\Informers;
use yii\helpers\ArrayHelper;

/* @var $this \yii\web\View */
$this->title = Title::showTitle($model->name); ?>
<section>
    <h1 class="title">Значение справочника: <?= $model->name; ?></h1>
    <?= Html::a("Назад", '/admin/informers-values/', ['class' => 'btn-main']) ?>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $this->render('../_forms/_informers-values', [
        'form' => $form,
        'model' => $model,
    ]) ?>
    <?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
    <?php ActiveForm::end(); ?>
</section>