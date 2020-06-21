<h1>Обновить прайсы по HTML</h1>
<?php $form = \yii\widgets\ActiveForm::begin(); ?>
<?= $form->field($model, 'file')->fileInput(); ?>
<?= \yii\helpers\Html::submitButton('Начать', ['class' => 'btn-main ']) ?>
<?php \yii\widgets\ActiveForm::end(); ?>