<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $model \app\modules\subscibe\models\entity\Subscribe */

?>
<?php $form = ActiveForm::begin([
	'options' => [
		'class' => 'subscribe'
	]
]); ?>
    <label class="subscribe__label">
		<?= Html::activeInput('text', $model, 'email', [
			'class' => 'subscribe__input',
			'placeholder' => 'Подпишись на обновления'
		]); ?>
    </label>
<?= Html::submitButton('<span>Подписаться</span><i class="fas fa-bell"></i>', [
	'class' => 'subscribe__button'
]); ?>
<?php ActiveForm::end(); ?>