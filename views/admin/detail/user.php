<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\entity\UserSex;

/* @var $model \app\models\entity\User */

$this->title = Title::showTitle("Пользователи"); ?>
<section>
    <h1 class="title">Пользователь: <?= $model->email; ?></h1>
    <?= Html::a("Назад", '/admin/user/', ['class' => 'btn-main']) ?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $this->render('../_forms/_user', [
        'model' => $model,
        'form' => $form,
        'groups' => $groups
    ]); ?>
    <?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end(); ?>
</section>