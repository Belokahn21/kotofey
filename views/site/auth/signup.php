<?

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\tool\seo\Title;

$this->title = Title::showTitle("Войти на сайт"); ?>
<div class="signin-wrap">
    <section class="signin">
        <h1 class="title">Регистрация</h1>
        <? $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'new_password')->passwordInput() ?>
        <?= Html::submitButton('Завершить', ['class' => 'btn-main']) ?>
        <?= Html::a('Авторизация', '/signin/', ['class' => 'link-main']) ?>
        <?/*
        <div class="signin__auth-social">
            <h6 class="signin__auth-social-title">войти с помощью</h6>
            <?= Html::a('<i class="fab fa-vk"></i>', $vkweb->authLink(), ['class' => 'btn-green']) ?>
        </div>
        */?>
        <? ActiveForm::end(); ?>
    </section>
</div>
