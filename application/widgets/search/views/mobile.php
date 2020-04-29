<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<?php $form = ActiveForm::begin([
    'method' => 'get',
    'action' => '/search/',
    'options' => [
        'class' => 'mobile-search-form'
    ]
]);
?>

    <div class="mobile-search-form__group">

        <?= $form->field($model, 'search', [
            'template' => '{input}',
            'options' => [
                'tag' => false,
            ]
        ])->textInput([
            'class' => 'mobile-search-form__input',
            'value' => Yii::$app->request->get('Search')['search'],
            'placeholder' => 'Поиск товара',
        ])->label(false); ?>
        <?= Html::submitButton('<i class="fas fa-search"></i>', ['class' => 'mobile-search-form__submit']) ?>
    </div>
<?php ActiveForm::end(); ?>