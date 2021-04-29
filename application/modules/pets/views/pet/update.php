<?php

/* @var $this \yii\web\View
 * @var $model \app\modules\pets\models\entity\Pets
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\Breadcrumbs;
use app\modules\seo\models\tools\Title;

$this->title = Title::show('Личный кабинет');
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => Url::to(['/profile/'])];
$this->params['breadcrumbs'][] = ['label' => 'Изменение даных питомца'];

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
    <h1 class="page__title">Изменить питомца: <?= $model->name; ?></h1>


    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'site-form',
            'style' => 'width:500px;'
        ]
    ]); ?>

    <div class="site-form__item">
        <label class="site-form__label" for="site-form-name">Имя питомца</label>
        <?= $form->field($model, 'name')->textInput([
            'class' => 'site-form__input',
            'id' => 'site-form-name',
            'placeholder' => 'Имя питомца',
        ])->label(false); ?>
    </div>
    <div class="site-form__item">
        <label class="site-form__label" for="site-form-birthday">День рождения</label>
        <?= $form->field($model, 'birthday')->textInput([
            'class' => 'site-form__input',
            'id' => 'site-form-birthday',
        ])->label(false); ?>
    </div>
    <div class="site-form__item">
        <label class="site-form__label" for="site-form-sex">Пол питомца</label>
        <?= $form->field($model, 'sex_id')->dropDownList($model->getSexes(), ['prompt' => 'Пол питомца', 'class' => 'site-form__input'])->label(false); ?>
    </div>
    <?= Html::submitButton('Обновить', [
        'class' => 'site-form__button'
    ]); ?>
    <?php ActiveForm::end(); ?>
</div>