<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\tool\seo\Title;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\entity\NewsCategory;

/* @var $model \app\models\entity\NewsCategory */
/* @var $this \yii\web\View */

$this->title = Title::showTitle("Рубрики");
?>
<section>
    <?= Html::a('Назад', Url::to(['index']), ['class' => 'btn-main']) ?>
    <h1 class="title">Рубрика: <?= $model->name; ?></h1>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $this->render('_form', [
        'model' => $model,
        'form' => $form,
    ]); ?>
    <?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
    <?php ActiveForm::end(); ?>
</section>