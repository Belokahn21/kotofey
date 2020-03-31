<?php

use app\models\entity\Category;
use app\models\tool\seo\Title;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $model \app\models\entity\Promo */

?>
<? $this->title = Title::showTitle("Промокод: " . $model->code); ?>
<section>
    <h1 class="title">Промокод: <?= $model->code; ?></h1>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $this->render('../_forms/_promo', [
        'form' => $form,
        'model' => $model,
    ]); ?>
    <?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
    <?php ActiveForm::end(); ?>
</section>