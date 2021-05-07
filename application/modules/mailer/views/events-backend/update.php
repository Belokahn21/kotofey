<?php

/* @var $this yii\web\View */

/* @var $model app\modules\delivery\models\entity\Delivery */

use app\modules\seo\models\tools\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Title::show($model->name);
?>
<section class="delivery">
    <div class="title-group">
        <h1 class="title">Почтовое событие: <?= $model->name; ?></h1>
        <?= Html::a("Назад", Url::to(['index']), ['class' => 'btn-main']) ?>
    </div>
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <?= $this->render('_form', [
        'model' => $model,
        'form' => $form,
    ]) ?>
    <?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
    <?php ActiveForm::end(); ?>
</section>