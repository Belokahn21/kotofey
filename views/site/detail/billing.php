<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\tool\seo\Title;
use yii\helpers\Url;

/* @var $models \app\models\entity\user\Billing */

$this->title = Title::showTitle("Личный кабинет");
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => '/profile/'];
$this->params['breadcrumbs'][] = ['label' => 'Адреса доставки', 'url' => '/billing/'];
$this->params['breadcrumbs'][] = ['label' => 'Адрес доставки: ' . $model->getName(), 'url' => Url::to(['site/billing', 'id' => $model->id])];
?>
    <h1>Редактировать адрес доставки: <?= $model->getName(); ?></h1>
<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'name')->textInput(['placeholder' => 'Пример: Доставка домой']) ?>
<?= $form->field($model, 'is_main')->checkbox(); ?>
<?= $form->field($model, 'city')->textInput(); ?>
<?= $form->field($model, 'street')->textInput(); ?>
<?= $form->field($model, 'home')->textInput(); ?>
<?= $form->field($model, 'house')->textInput(); ?>
<?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>