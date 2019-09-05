<?

use app\models\tool\seo\Title;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\entity\UserSex;

/* @var $model \app\models\entity\User */

$this->title = Title::showTitle("Пользователи"); ?>
<section>
    <h1 class="title">Пользователь: <?= $model->email; ?></h1>
    <?= Html::a("Назад", '/admin/user/', ['class' => 'btn-back']) ?>
    <? $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="tabs-container">
        <ul class="tabs">
            <li class="tab-link current" data-tab="tab-1">Основное</li>
            <li class="tab-link" data-tab="tab-2">Аватар</li>
            <li class="tab-link" data-tab="tab-3">Разрешения</li>
            <li class="tab-link" data-tab="tab-4">Расширенное</li>
        </ul>

        <div id="tab-1" class="tab-content current">
            <?= $form->field($model, 'email'); ?>
            <?//= $form->field($model, 'phone'); ?>
            <?= $form->field($model, 'new_password')->passwordInput(); ?>
        </div>
        <div id="tab-2" class="tab-content">
            <img src="<?= $model->avatar; ?>" width="300" alt="<?= $model->email ?>" title="<?= $model->email; ?>">
            <?= $form->field($model, 'avatarFile')->fileInput(); ?>
        </div>
        <div id="tab-3" class="tab-content">
            <div class="left-col">
                <h2>Группы</h2>
                <?= $form->field($model, 'roleName')->dropDownList(ArrayHelper::map($groups, 'name', 'name'),
                    ['prompt' => 'Группа']); ?>
            </div>
            <div class="right-col">
                <h2>Разрешения</h2>
            </div>
            <div class="clearfix"></div>
        </div>
        <div id="tab-4" class="tab-content">
            <?= $form->field($model, 'first_name'); ?>
            <?= $form->field($model, 'name'); ?>
            <?= $form->field($model, 'last_name'); ?>
            <?= $form->field($model, 'birthday')->textInput(); ?>
            <?= $form->field($model, 'sex')->dropDownList(ArrayHelper::map(UserSex::find()->all(), 'id', 'name'),
                ['prompt' => 'Выбрать пол']); ?>
            <div class="clearfix"></div>
        </div>
    </div>
    <?= Html::submitButton('Обновить', ['class' => 'btn-main']); ?>
    <? ActiveForm::end(); ?>
</section>