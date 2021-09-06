<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\seo\models\tools\Title;

/* @var $model \app\modules\news\models\entity\NewsCategory */
/* @var $this \yii\web\View */

$this->title = Title::show($model->name);
?>
<div class="title-group">
    <h1 class="title"><?= $model->name; ?></h1>
    <?= Html::a('Назад', Url::to(['index']), ['class' => 'btn-main']) ?>
</div>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<?= $this->render('_form', [
    'model' => $model,
    'form' => $form,
]); ?>
<?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end(); ?>
