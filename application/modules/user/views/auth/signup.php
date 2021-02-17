<?php

use app\modules\seo\models\tools\Title;
use app\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $model \app\modules\user\models\form\PasswordRestoreForm */

$this->title = Title::show("Авторизация");
$this->params['breadcrumbs'][] = ['label' => 'Войти на сайт', 'url' => ['/signin/']];
?>

<div class="page">
    <?= Breadcrumbs::widget([
        'homeLink' => [
            'label' => 'Главная ',
            'url' => Yii::$app->homeUrl,
            'title' => 'Первая страница сайта зоомагазина Котофей',
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]); ?>

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'site-form auth-form'
        ],
    ]); ?>
    <?= Html::tag('h1', 'Регистрация', ['class' => 'page__title']) ?>

    <div class="site-form__item">
        <?= $form->field($model, 'email')->textInput([
            'class' => 'site-form__input',
            'id' => 'site-form-email',
            'placeholder' => 'E-Mail',
        ])->label(false); ?>
    </div>

    <div class="site-form__item">
        <?= $form->field($model, 'phone')->textInput([
            'class' => 'site-form__input js-mask-ru',
            'id' => 'site-form-phone',
            'placeholder' => 'Телефон',
        ])->label(false); ?>
    </div>

    <div class="site-form__item">
        <?= $form->field($model, 'password')->passwordInput([
            'class' => 'site-form__input',
            'id' => 'site-form-password',
            'placeholder' => 'Пароль',
        ])->label(false); ?>
    </div>


    <div class="auth-form__controls">
        <?= Html::submitButton('Зарегестрироваться', ['class' => 'btn-main']); ?>
        <?= Html::a('Восстановить пароль', Url::to(['auth/restore']), ['class' => 'auth-form__restore-link']); ?>
        <?= Html::a('Войти на сайт', Url::to(['auth/signin']), ['class' => 'auth-form__restore-link']); ?>
    </div>

    <?php /*
    <div class="auth-form-social-container">
        <div class="auth-form-social-title">Войти через:</div>
        <div class="auth-form-social">
            <?= yii\authclient\widgets\AuthChoice::widget([
                'baseAuthUrl' => ['vk'],
                'popupMode' => false,
            ]) ?>
        </div>
    </div>*/ ?>

    <?php ActiveForm::end(); ?>
</div>
