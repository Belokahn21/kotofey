<?php

use app\modules\seo\models\tools\Title;
use app\widgets\Breadcrumbs;
use yii\helpers\Url;

$this->title = Title::show("Авторизация");
$this->params['breadcrumbs'][] = ['label' => 'Восстановить пароль', 'url' => ['/restore/']];
$this->params['breadcrumbs'][] = ['label' => 'Регистрация', 'url' => ['/signup/']]; ?>

<div class="page">
    <?= Breadcrumbs::widget([
        'homeLink' => [
            'label' => 'Главная ',
            'url' => Yii::$app->homeUrl,
            'title' => 'Первая страница сайта зоомагазина Котофей',
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]); ?>

    <form class="site-form auth-form">
        <h1 class="page__title">Авторизация</h1>
        <div class="site-form__item">
            <label class="site-form__label">
                <input class="site-form__input" type="text" name="email" placeholder="E-Mail">
            </label>
        </div>
        <div class="site-form__item">
            <label class="site-form__label">
                <input class="site-form__input" type="password" name="password" placeholder="Пароль">
            </label>
        </div>

        <div class="auth-form__controls">
            <button class="btn-main" type="submit">Войти на сайт</button>
            <a class="auth-form__restore-link" href="<?= Url::to(['auth/restore']); ?>">Восстановить пароль</a>
            <a class="auth-form__restore-link" href="<?= Url::to(['auth/signup']); ?>">Зарегестрироваться</a>
        </div>

        <div class="auth-form-social-container">
            <div class="auth-form-social-title">Войти через:</div>
            <div class="auth-form-social">
                <a class="auth-form-social__item" href="#">
                    <img class="auth-form-social__image" src="/images/vk.png">
                </a>
            </div>
        </div>
    </form>
</div>
