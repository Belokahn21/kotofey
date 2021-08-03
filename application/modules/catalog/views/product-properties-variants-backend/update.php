<?php

use app\modules\seo\models\tools\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model \app\modules\catalog\models\entity\PropertiesVariants */
/* @var $this \yii\web\View */

$this->title = Title::show($model->name); ?>


<div class="title-group">
    <h1><?= $model->name; ?></h1>
    <?= Html::a("Назад", Url::to(['index']), ['class' => 'btn-main']) ?>
</div>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<?= $this->render('_form', [
    'form' => $form,
    'model' => $model,
]) ?>
<?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end(); ?>
