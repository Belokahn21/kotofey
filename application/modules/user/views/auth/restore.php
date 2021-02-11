<?php

use app\modules\seo\models\tools\Title;
use app\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $model \app\modules\user\models\form\PasswordRestoreForm */

$this->title = Title::show("Восстановить пароль");
$this->params['breadcrumbs'][] = ['label' => 'Войти на сайт', 'url' => ['/signin/']];
$this->params['breadcrumbs'][] = ['label' => 'Регистрация', 'url' => ['/signup/']];
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
        ]
    ]); ?>
    <?= Html::tag('h1', 'Восстановить пароль') ?>

    <?= $form->field($model, 'email')->textInput([
        'class' => 'site-form__input',
        'id' => 'site-form-email',
        'placeholder' => 'Адрес вашей электронной почты',
    ])->label(false); ?>

    <div class="auth-form__controls">
        <?= Html::submitButton('Восстановить', ['class' => 'btn-main']); ?>
        <?= Html::a('Войти на сайт', Url::to(['auth/signin']), ['class' => 'auth-form__restore-link']); ?>
        <?= Html::a('Зарегестрироваться', Url::to(['auth/signup']), ['class' => 'auth-form__restore-link']); ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
