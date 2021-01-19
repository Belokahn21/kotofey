<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\tool\seo\Title;
use yii\helpers\Url;

/* @var $categories \app\modules\catalog\models\entity\ProductCategory[] */

$this->title = Title::showTitle("Раздел: " . $model->name); ?>
<section>
    <h1 class="title">Раздел: <?= $model->name; ?></h1>
    <?= Html::a("Назад", Url::to(['index']), ['class' => 'btn-main']) ?>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $this->render('_form', [
        'form' => $form,
        'model' => $model,
        'categories' => $categories,
    ]); ?>
    <?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
    <?php ActiveForm:: end(); ?>
</section>