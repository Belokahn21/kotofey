<?php

use app\modules\seo\models\tools\Title;
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

$this->title = Title::show("Поставщик:" . $model->name); ?>
<section>
    <div class="title-group">
        <h1 class="title"><?= $model->name; ?></h1>
        <?= Html::a('Назад', \yii\helpers\Url::to(['index']), ['class' => 'btn-main']); ?>
    </div>
    <div class="product-form">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <?= $this->render('_form', [
            'model' => $model,
            'form' => $form
        ]); ?>
        <?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
        <?php ActiveForm::end(); ?>
    </div>
</section>