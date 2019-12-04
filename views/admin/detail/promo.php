<?php

use app\models\entity\Category;
use app\models\tool\seo\Title;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $model \app\models\entity\Promo */

?>
<? $this->title = Title::showTitle("Промокоды"); ?>
<section>
    <h1 class="title">Промокоды</h1>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="tabs-container">
        <ul class="tabs">
            <li class="tab-link current" data-tab="tab-1">Основное</li>
        </ul>

        <div id="tab-1" class="tab-content current">
            <?= $form->field($model, 'code'); ?>
            <?= $form->field($model, 'discount'); ?>
            <?= $form->field($model, 'count'); ?>
        </div>

    </div>
    <?= Html::submitButton('Обновить'); ?>
<?php ActiveForm::end(); ?>
</section>
