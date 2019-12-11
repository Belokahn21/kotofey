<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\tool\seo\Title;

/* @var $model \app\models\entity\User */

$this->params['breadcrumbs'][] = ['label' => 'Авторизация', 'url' => ['/signin/']];
$this->params['breadcrumbs'][] = ['label' => 'Регистрация', 'url' => ['/signup/']];
$this->title = Title::showTitle("Регистрация"); ?>


<div class="auth-wrap">
    <img class="auth-image" src="/upload/images/_logo.png">
    <h1 class="title">Регистрация</h1>

	<?php $form = ActiveForm::begin([
		'options' => [
			'class' => 'auth-form'
		],
	]); ?>

    <input style="display:none" type="text" name="fakeusernameremembered"/>
    <input style="display:none" type="password" name="fakepasswordremembered"/>

    <div class="input-group auth-input-group">
		<?= $form->field($model, 'email', [
			'enableAjaxValidation' => true,
			'template' => '
            <div class="input-group auth-input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text auth-input-group-text"><i class="fas fa-at"></i></span>
                </div>
                {input}
            </div>{error}'
		])->textInput(['class' => 'form-control', 'id' => 'email-auth-id', 'placeholder' => 'Email', 'autocomplete' => 'h87h58g7h8hd'])->label(false); ?>
    </div>

    <div class="input-group auth-input-group">
		<?= $form->field($model, 'phone', [
			'enableAjaxValidation' => true,
			'template' => '
            <div class="input-group auth-input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text auth-input-group-text"><i class="fas fa-mobile-alt"></i></span>
                </div>
                {input}
            </div>{error}'
		])->textInput(['class' => 'form-control', 'id' => 'phone-auth-id', 'placeholder' => 'Телефон', 'autocomplete' => 'h87h58g7h8hd'])->label(false); ?>
    </div>

    <div class="input-group auth-input-group">
		<?= $form->field($model, 'password', [
			'template' => '
            <div class="input-group auth-input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text auth-input-group-text"><i class="fas fa-key"></i></span>
                </div>
                {input}
            </div>{error}'
		])->passwordInput(['class' => 'form-control', 'id' => 'password-auth-id', 'placeholder' => 'Пароль', 'autocomplete' => 'h87h58g7h8hd'])->label(false); ?>
    </div>

	<?= Html::submitButton('Завершить', ['class' => 'btn-main']); ?>
	<?= Html::a('Авторизация', Url::to(['site/signin']), ['class' => 'link-main']); ?>
	<?php ActiveForm::end(); ?>
</div>