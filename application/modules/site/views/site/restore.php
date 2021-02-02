<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\modules\seo\models\tools\Title;

$this->params['breadcrumbs'][] = ['label' => 'Авторизация', 'url' => ['/signin/']];
/* @var $model \app\modules\user\models\entity\User */
$this->title = Title::show("Восстановить пароль"); ?>
<div class="auth-wrap">
	<img class="auth-image" src="/upload/images/_logo.png">
	<h1 class="title">Восстановить пароль</h1>

	<?php $form = ActiveForm::begin([
		'options' => [
			'class' => 'auth-form'
		],
	]); ?>

	<input style="display:none" type="text" name="fakeusernameremembered"/>
	<input style="display:none" type="password" name="fakepasswordremembered"/>

	<div class="input-group auth-input-group">
		<?= $form->field($model, 'email', [
			'template' => '
            <div class="input-group auth-input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text auth-input-group-text"><i class="fas fa-at"></i></span>
                </div>
                {input}
            </div>{error}'
		])->textInput(['class' => 'form-control', 'id' => 'email-auth-id', 'placeholder' => 'Email', 'autocomplete' => 'h87h58g7h8hd'])->label(false); ?>
	</div>

	<?= Html::submitButton('Отправить', ['class' => 'btn-main']); ?>
	<?= Html::a('Регистрация', Url::to(['site/signup']), ['class' => 'link-main']); ?>
	<?= Html::a('Авторизация', Url::to(['site/signin']), ['class' => 'link-main ml-5']); ?>
	<?php ActiveForm::end(); ?>
</div>