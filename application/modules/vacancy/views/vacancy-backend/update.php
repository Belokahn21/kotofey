<?php

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\modules\seo\models\tools\Title;

/* @var $this \yii\web\View */
/* @var $model \app\modules\vacancy\models\entity\Vacancy */
/* @var $city_list \app\modules\geo\models\entity\Geo[] */

$this->title = Title::show("Вакансии");;

?>
    <h1 class="title">Вакансия: <?= $model->title; ?></h1>
<?php $form = ActiveForm::begin(); ?>
<?= $this->render('_form', [
    'form' => $form,
    'model' => $model,
    'city_list' => $city_list
]) ?>
<?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>