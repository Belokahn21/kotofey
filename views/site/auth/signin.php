<?

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\tool\seo\Title;

/* @var $model \app\models\entity\User */
$this->title = Title::showTitle("Войти на сайт"); ?>
<div class="signin-wrap">
    <section class="signin">
        <h1 class="title">Войти на сайт</h1>
        <? $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'password')->passwordInput(); ?>
        <?= Html::submitButton('Войти', ['class' => 'btn-main']) ?>
        <?= Html::a('Регистрация', '/signup/', ['class' => 'link-main']) ?>
        <? ActiveForm::end(); ?>
    </section>
</div>
