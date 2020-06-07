<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\entity\Category;
use app\models\entity\InformersValues;
use app\models\entity\Stocks;
use app\models\entity\SiteSettings;


/* @var $model \app\models\entity\GeoTimezone
 */

$this->title = Title::showTitle("Временные зоны"); ?>
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