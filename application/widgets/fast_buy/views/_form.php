<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<div class="fast-buy-billing">
    <div class="container">
        <div class="row">
            <div class="col">
                <?= $form->field($user, 'email')->textInput(['class' => 'fast-buy-billing-form__item', 'placeholder' => 'Email']); ?>
            </div>
            <div class="col">
                <?= $form->field($user, 'phone')->textInput(['class' => 'fast-buy-billing-form__item', 'placeholder' => 'Телефон']); ?>
            </div>
            <div class="col">
                <?= $form->field($user, 'password')->passwordInput(['class' => 'fast-buy-billing-form__item', 'placeholder' => 'Пароль']); ?>
            </div>
        </div>
    </div>
</div>