<h1>Обновить прайсы по HTML</h1>
<?php $form = \yii\widgets\ActiveForm::begin(); ?>
<?= $form->field($model, 'file')->fileInput(); ?>
<?php \yii\widgets\ActiveForm::end(); ?>