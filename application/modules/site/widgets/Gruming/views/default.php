<?php
/* @var $model \app\modules\site\models\forms\GrumingForm */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>

<?php if ($this->beginCache('gruming-widget-cache', ['duration' => 3600 * 24 * 7])): ?>
    <a name="gruming"></a>
    <div class="page-container">
        <div class="page-title__group is-column">
            <h2 class="page-title">Услуги</h2>
        </div>
    </div>
    <div class="gruming-container">
        <div class="gruming-wrap">
            <img src="/images/ketty_grum.jpg">
        </div>
        <?php $form = ActiveForm::begin([
            'options' => [
                'class' => 'gruming-form site-form'
            ]
        ]); ?>
        <div class="gruming-form__title">Зоосалон Ohmypet</div>
        <div class="site-form__item">
            <?= $form->field($model, 'pet')->dropDownList($model->getPets(), ['prompt' => 'Выберите питомца', 'class' => 'form-control site-form__select'])->label(false); ?>
        </div>
        <div class="site-form__item">
            <?= $form->field($model, 'service')->dropDownList($model->getServices(), ['prompt' => 'Выберите услугу', 'class' => 'form-control site-form__select'])->label(false); ?>
        </div>
        <div class="site-form__item">
            <?= $form->field($model, 'phone')->textInput(['placeholder' => 'Ваш телефон', 'class' => 'js-mask-ru site-form__input'])->label(false) ?>
        </div>
        <div class="site-form__item">
            <?= $form->field($model, 'client')->textInput(['placeholder' => 'Представьтесь', 'class' => 'site-form__input'])->label(false) ?>
        </div>
        <div class="site-form__item">
            <?= $form->field($model, 'date')->textInput(['placeholder' => 'Удобный день посещения', 'class' => 'js-datepicker site-form__input'])->label(false) ?>
        </div>
        <?= Html::submitButton('Записаться', ['class' => 'site-form__button']); ?>
        <div class="gruming-form__spoiler">Зоосалон Ohmypet - является партнером интернет-магазина Котофей. Сбор и обработка заявок на услуги зоосалона выполняются персоналом Ohmypet</div>
        <?php ActiveForm::end() ?>
    </div>
    <?php $this->endCache(); endif; ?>
