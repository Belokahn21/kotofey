<?php

use app\models\entity\NewsCategory;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\tool\seo\Title;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $model \app\models\entity\News */

$this->title = Title::showTitle("Новости");
?>


<section>
    <?= Html::a("Назад", Url::to(['index']), ['class' => 'btn-main']) ?>
    <h1 class="title"><?= $model->title; ?></h1>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $this->render('_form', [
        'form' => $form,
        'model' => $model,
    ]); ?>
    <?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
    <?php ActiveForm:: end(); ?>
</section>