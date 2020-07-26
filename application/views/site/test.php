<?php

use yii\widgets\Pjax;
use yii\helpers\Html;

?>
<?php Pjax::begin(); ?>
<?= Html::beginForm('/test/', 'post', ['data-pjax' => '', 'class' => 'form-inline']); ?>
<?= Html::input('text', 'string', Yii::$app->request->post('string'), ['class' => 'form-control']) ?>
<?= Html::submitButton('Получить хеш', ['class' => 'btn btn-lg btn-primary', 'name' => 'hash-button']) ?>
<?= Html::endForm() ?>
    <h3><?= $stringHash ?>ss</h3>
<?php Pjax::end(); ?>