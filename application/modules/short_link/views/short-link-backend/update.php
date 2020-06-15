<?php

use yii\helpers\Html;
use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;

/* @var $this \yii\web\View */
/* @var $model \app\models\entity\ShortLinks */

$this->title = Title::showTitle("Короткие ссылки");
?>
    <h1>Короткая ссылка: <?= $model->short_code; ?></h1>
<?php $form = ActiveForm::begin(); ?>
<?= $this->render('../_forms/_shortly', [
    'form' => $form,
    'model' => $model
]); ?>
<?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end(); ?>