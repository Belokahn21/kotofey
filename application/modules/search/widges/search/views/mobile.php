<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\search\widges\LastQuery\LastQueryWidget;

?>
<div class="js-search-form mobile-search">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'mobile-search-form',
        ],
        'action' => \yii\helpers\Url::to(['/search/']),
        'method' => 'get',
        'fieldConfig' => [
            'options' => [
                'tag' => false,
            ],
        ],
    ]);
    ?>

    <?= Html::button('<i class="fas fa-times"></i>', [
        'class' => 'mobile-search-form__close mobile-search-form__control js-search-toggle'
    ]) ?>

    <?= Html::activeInput('text', $model, 'search', [
        'class' => 'mobile-search-form__input js-live-search',
        'placeholder' => 'Найти товар',
        'value' => $model->search
    ]) ?>

    <?= Html::submitButton('Найти', [
        'class' => 'mobile-search-form__submit mobile-search-form__control'
    ]); ?>


    <?php ActiveForm::end(); ?>

    <?= LastQueryWidget::widget(); ?>
</div>