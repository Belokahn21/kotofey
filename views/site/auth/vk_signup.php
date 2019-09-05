<?

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\tool\seo\Title;

/* @var \app\models\tool\vk\entity\VKUser $vkuser */
$this->title = Title::showTitle("Войти на сайт"); ?>
<section class="signin">
    <h1 class="title">Регистрация</h1>
    <? $form = ActiveForm::begin(); ?>
    <div class="vk-user-info">
        <img class="vk-user-info__image" src="<?= $vkuser['photo_big']; ?>" alt="<?= $vkuser['first_name']; ?>" title="<?= $vkuser['first_name']; ?>">
        <h1 class="vk-user-info__title"><?= $vkuser['first_name']; ?>&nbsp;<?= $vkuser['last_name']; ?></h1>
    </div>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'new_password')->passwordInput() ?>
    <?= Html::submitButton('Завершить', ['class' => 'btn-main']) ?>
    <div class="signin__auth-social">
        <h6 class="signin__auth-social-title">войти с помощью</h6>
        <?= Html::a('<i class="fab fa-vk"></i>', $vkweb->authLink(), ['class' => 'btn-green']) ?>
    </div>
    <? ActiveForm::end(); ?>
</section>
