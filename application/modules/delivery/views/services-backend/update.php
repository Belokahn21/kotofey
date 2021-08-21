<?php
/* @var $this \yii\web\View */

/* @var $model */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = \app\modules\seo\models\tools\Title::show($model->name);
?>


<div class="title-group">
    <h1><?= $model->name; ?></h1>
    <?= Html::a('Назад', Url::to(['index']), ['class' => 'btn-main']); ?>
</div>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
]) ?>
<?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>
