<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $signin \app\modules\user\models\entity\User */
/* @var $signup \app\modules\user\models\entity\User */

?>

<div class="modal fade authModal" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php $signupForm = ActiveForm::begin([
                'enableAjaxValidation' => true,
                'action' => Url::to(['/user/auth/signup']),
                'options' => [
                    'class' => 'auth-form'
                ]
            ]); ?>
            <div class="modal-header">
                <div class="div"><h5 class="modal-title" id="signupModalLabel">Регистрация</h5>
                    <ul class="auth-modal-toggle">
                        <li class="auth-modal-toggle__item active">
                            <a class="auth-modal-toggle__link" href="javascript:void(0);" data-toggle="modal" data-target="#signupModal">Регистрация</a>
                        </li>
                        <li class="auth-modal-toggle__item">
                            <a class="auth-modal-toggle__link" href="javascript:void(0);" data-toggle="modal" data-target="#signinModal">Вход</a>
                        </li>
                    </ul>
                </div>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="auth-form__item">
                    <label class="auth-form__label" for="auth-form-email">Адрес вашей электронной почты</label>
                    <?= $signupForm->field($signup, 'email')->textInput([
                        'class' => 'auth-form__input',
                        'id' => 'auth-form-email',
                        'placeholder' => 'Адрес вашей электронной почты',
                    ])->label(false); ?>
                </div>
                <div class="auth-form__item">
                    <label class="auth-form__label" for="auth-form-phone">Контактный телефон</label>
                    <?= $signupForm->field($signup, 'phone')->textInput([
                        'class' => 'auth-form__input js-mask-ru',
                        'id' => 'auth-form-phone',
                        'placeholder' => '+7 (___) ___ __-__',
                    ])->label(false); ?>
                </div>
                <div class="auth-form__item">
                    <label class="auth-form__label" for="auth-form-password">Пароль</label>
                    <?= $signupForm->field($signup, 'password')->passwordInput([
                        'class' => 'auth-form__input',
                        'id' => 'auth-form-password',
                        'placeholder' => 'Пароль',
                    ])->label(false); ?>
                </div>
            </div>
            <div class="modal-footer">
                <?= Html::submitButton('Регистрация', [
                    'class' => 'auth-form__button'
                ]); ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<div class="authModal modal fade" id="signinModal" tabindex="-1" role="dialog" aria-labelledby="signinModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php $signinForm = ActiveForm::begin([
                'action' => Url::to(['/user/auth/signin']),
                'options' => [
                    'class' => 'auth-form'
                ]
            ]); ?>
            <div class="modal-header">
                <div class="div"><h5 class="modal-title" id="signinModalLabel">Войти в личный кабинет</h5>
                    <ul class="auth-modal-toggle">
                        <li class="auth-modal-toggle__item">
                            <a class="auth-modal-toggle__link" href="javascript:void(0);" data-toggle="modal" data-target="#signupModal">Регистрация</a>
                        </li>
                        <li class="auth-modal-toggle__item active">
                            <a class="auth-modal-toggle__link" href="javascript:void(0);" data-toggle="modal" data-target="#signinModal">Вход</a>
                        </li>
                    </ul>
                </div>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="auth-form__item">
                    <label class="auth-form__label" for="auth-form-email">Адрес вашей электронной почты</label>
                    <?= $signinForm->field($signin, 'email')->textInput([
                        'class' => 'auth-form__input',
                        'id' => 'auth-form-email',
                        'placeholder' => 'Адрес вашей электронной почты',
                    ])->label(false); ?>
                </div>
                <div class="auth-form__item">
                    <label class="auth-form__label" for="auth-form-password">Пароль</label>
                    <?= $signinForm->field($signin, 'password')->passwordInput([
                        'class' => 'auth-form__input',
                        'id' => 'auth-form-password',
                        'placeholder' => 'Пароль',
                    ])->label(false); ?>
                </div>
                <div class="modal-footer">
                    <?= Html::submitButton('Авторизоваться', [
                        'class' => 'auth-form__button'
                    ]); ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
