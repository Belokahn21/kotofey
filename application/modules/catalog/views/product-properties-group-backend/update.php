<?php

use app\modules\catalog\models\entity\SaveInformers;
use app\modules\catalog\models\entity\TypeProductProperties;
use app\modules\seo\models\tools\Title;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = Title::show("Свойства товаров"); ?>
<section>
    <?= Html::a("Назад", Url::to(['index']), ['class' => 'btn-main']) ?>
    <h1 class="title">Свойство: <?= $model->name; ?></h1>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $this->render('_form', [
        'model' => $model,
        'form' => $form,
    ]); ?>
    <?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
    <?php ActiveForm::end(); ?>
</section>