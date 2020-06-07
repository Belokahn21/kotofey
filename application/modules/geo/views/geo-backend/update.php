<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $model \app\models\entity\Geo */
/* @var $this \yii\web\View */
/* @var $time_zones \app\models\entity\GeoTimezone[] */

$this->title = Title::showTitle("Гео объекты"); ?>
<section>
    <h1 class="title">Гео объекты</h1>
    <div class="celearfix"></div>
    <div class="product-form">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <?= $this->render('_form', [
            'form' => $form,
            'model' => $model,
            'time_zones' => $time_zones,
        ]); ?>
        <?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
        <?php ActiveForm::end(); ?>
    </div>
</section>
<div class="clearfix"></div>
