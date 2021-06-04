<?php

use app\modules\seo\models\tools\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var \yii\web\View $this */
/* @var \app\modules\vendors\models\entity\Vendor $model */

$this->title = Title::show("Поставщики"); ?>
<section>
    <h1 class="title">Поставщики</h1>
    <?= Html::a('Назад', ['index'], ['class' => 'btn-main']) ?>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $this->render('_form', [
        'model' => $model,
        'form' => $form
    ]); ?>
    <?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
    <?php ActiveForm::end(); ?>
</section>