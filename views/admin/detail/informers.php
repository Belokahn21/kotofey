<?php

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = Title::showTitle("Справочники"); ?>
<section>
    <h1 class="title">Справочник: <?= $model->name; ?></h1>
    <?= Html::a("Назад", '/admin/informers/', ['class' => 'btn-back']) ?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="tabs-container">
        <ul class="tabs">
            <li class="tab-link current" data-tab="tab-1">Основное</li>
        </ul>

        <div id="tab-1" class="tab-content current">
            <?= $form->field($model, 'name') ?>
            <?= $form->field($model, 'description')->textarea(); ?>
            <?= $form->field($model, 'sort')->textInput() ?>
        </div>

    </div>
    <?= Html::submitButton('Обновить'); ?>
<?php ActiveForm::end(); ?>
</section>
