<?php

use app\modules\seo\models\tools\Title;
use app\widgets\Breadcrumbs;
use yii\helpers\Url;

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

    <form class="site-form auth-form">
        <h1 class="page__title">Восстановить пароль</h1>
        <div class="site-form__item">
            <label class="site-form__label">
                <input class="site-form__input" type="text" name="email" placeholder="E-Mail">
            </label>
        </div>
        <div class="site-form__item">
            <label class="site-form__label">
                <input class="site-form__input" type="text" name="phone" placeholder="Телефон">
            </label>
        </div>
        <div class="site-form__item">
            <label class="site-form__label">
                <input class="site-form__input" type="password" name="password" placeholder="Пароль">
            </label>
        </div>
        <div class="auth-form__controls">
            <button class="btn-main" type="submit">Войти на сайт</button>
            <a class="auth-form__restore-link" href="<?= Url::to(['auth/signin']); ?>">Войти на сайт</a>
            <a class="auth-form__restore-link" href="<?= Url::to(['auth/signup']); ?>">Зарегестрироваться</a>
        </div>

    </form>
</div>
