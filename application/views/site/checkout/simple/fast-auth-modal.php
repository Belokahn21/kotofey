<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$model = new \app\modules\user\models\entity\User(['scenario' => \app\modules\user\models\entity\User::SCENARIO_LOGIN]);
?>
<div class="modal fade" id="fast-auth-id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
		<?php $form = ActiveForm::begin([
			'options' => [
				'class' => 'ajax-login'
			],
		]); ?>
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Авторизация на сайте</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="auth-wrap">
                    <img class="auth-image" src="/upload/images/_logo.png">
                    <h1 class="title">Войти на сайт</h1>

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
                </div>
            </div>
            <div class="modal-footer">
				<?= Html::a('Регистрация', Url::to(['site/signup']), ['class' => 'link-main']); ?>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть окно</button>
                <button type="submit" class="btn btn-main">Авторизоваться</button>
            </div>
        </div>
		<?php ActiveForm::end(); ?>
    </div>
</div>