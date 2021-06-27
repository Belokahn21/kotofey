<?php

use app\modules\seo\models\tools\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var \yii\web\View $this */
/* @var \app\modules\vendors\models\entity\Vendor $model */

$this->title = Title::show($model->name); ?>
<section>
    <div class="title-group">
        <h1 class="title"><?= $model->name; ?></h1>
        <?= Html::a('Назад', \yii\helpers\Url::to(['index']), ['class' => 'btn-main']); ?>
    </div>
    <div class="product-form">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <?= $this->render('_form', [
            'model' => $model,
            'form' => $form
        ]); ?>
        <?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
        <?php ActiveForm::end(); ?>
    </div>
</section>