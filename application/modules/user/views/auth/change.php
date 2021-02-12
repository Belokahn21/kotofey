<?php

use app\modules\seo\models\tools\Title;
use app\widgets\Breadcrumbs;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $model \app\modules\user\models\form\PasswordRestoreForm
 * @var $message string
 */


$this->title = Title::show("Смена пароля");
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

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'site-form auth-form'
        ],
    ]); ?>
    <?= Html::tag('h1', 'Смена пароля', ['class' => 'page__title']) ?>

    <div class="site-form__item">
        <?= $form->field($model, 'password')->textInput([
            'class' => 'site-form__input',
            'id' => 'site-form-password',
            'placeholder' => 'Пароль',
        ])->label(false); ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
