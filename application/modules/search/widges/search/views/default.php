<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $model \app\modules\search\models\entity\Search */

$phrase = @Yii::$app->request->get()['Search']['search'];
?>

<?php if (Yii::$app->request->get('search') == 'Y'): ?>
    <div class="search-react"></div>
<?php else: ?>
    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'search-form',
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
    <div class="search-form__input-group">
        <?= Html::submitButton(Html::img('/upload/images/search.svg', ['class' => 'search-form__icon']), ['class' => 'search-form__button']) ?>
        <?= $form->field($model, 'search')->textInput(['placeholder' => 'Найти товар...', 'class' => 'js-live-search search-form__input', 'value' => $phrase])->label(false) ?>
    </div>
    <?php ActiveForm::end(); ?>
<?php endif; ?>



