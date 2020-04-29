<?php

use app\models\tool\seo\Title;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Title::showTitle("Статусы технической поддержки"); ?>
<section>
    <h1 class="title">Статусы</h1>
<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name'); ?>
    <?= $form->field($model, 'sort'); ?>
	<?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end(); ?>
</section>
