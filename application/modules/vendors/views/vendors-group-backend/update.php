<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\modules\catalog\models\entity\ProductCategory;
use app\modules\catalog\models\entity\SaveInformersValues;
use app\modules\stock\models\entity\Stocks;
use app\modules\site_settings\models\entity\SiteSettings;

/* @var \yii\web\View $this */

$this->title = Title::show("Поставщики"); ?>
<section>
    <h1 class="title">Поставщики</h1>
    <?= Html::a('Назад', ['index'], ['class' => 'btn-main']) ?>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $this->render('_form', [
        'model' => $model,
        'form' => $form
    ]); ?>
    <?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
    <?php ActiveForm::end(); ?>
</section>