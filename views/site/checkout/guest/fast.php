<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\entity\Order;

?>
<?php $form = ActiveForm::begin(); ?>
<div class="order-type-form__title">Регистрация</div>
<?= $form->field($user, 'phone')->textInput(['placeholder' => 'Телефон'])->label(false); ?>
<?= $form->field($user, 'email')->textInput(['placeholder' => 'Почта'])->label(false); ?>
<?= $form->field($user, 'password')->passwordInput(['placeholder' => 'Пароль'])->label(false); ?>
<?= Html::hiddenInput('type', Order::SCENARIO_FAST_ORDER) ?>
<?= Html::submitButton('Купить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end(); ?>