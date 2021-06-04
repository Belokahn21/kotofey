<?php

use app\modules\seo\models\tools\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $model \app\modules\geo\models\entity\GeoTimezone */

$this->title = Title::show("Временные зоны"); ?>
<section>
    <?= Html::a('Назад', Url::to(['index']), ['class' => 'btn-main']) ?>
    <h1 class="title">Временная зона: <?= $model->name; ?></h1>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $this->render('_form', [
        'model' => $model,
        'form' => $form,
    ]); ?>
    <?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
    <?php ActiveForm::end(); ?>
</section>