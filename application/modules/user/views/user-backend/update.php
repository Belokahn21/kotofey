<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\modules\user\models\entity\UserSex;

/* @var $model \app\modules\user\models\entity\User */

$this->title = Title::show("Пользователи"); ?>
<section>
    <h1 class="title">Пользователь: <?= $model->email; ?></h1>
    <?= Html::a("Назад", ['index'], ['class' => 'btn-main']) ?>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $this->render('_form', [
        'model' => $model,
        'form' => $form,
        'groups' => $groups
    ]); ?>
    <?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
    <?php ActiveForm::end(); ?>
</section>