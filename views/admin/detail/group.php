<?php

/* @var $this yii\web\View */

/* @var $model \app\models\rbac\AuthItem */

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = Title::showTitle("Управление группами");
?>
<section class="group-form">
    <div class="group-form-wrap">
        <h1 class="title">Группа: <?= $model->name; ?></h1>
        <?php $form = ActiveForm::begin(); ?>
        <?= $this->render('../_forms/_group', [
            'model' => $model,
            'form' => $form
        ]); ?>
        <?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
        <?php ActiveForm::end(); ?>
    </div>
</section>