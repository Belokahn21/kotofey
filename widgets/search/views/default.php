<?

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="search">

    <? $form = ActiveForm::begin([
        'method' => 'get',
        'action'=>'/search/'
    ]);
    ?>
    <?= $form->field($model, 'search', [
        'template' => '{input}',
        'options' => [
            'tag' => false,
        ]
    ])->textInput(['class' => 'search__text', 'value' => $model->search, 'placeholder' => 'Поиск овара'])->label(false); ?>
    <?= Html::submitButton('<i class="fas fa-search"></i>') ?>
    <? ActiveForm::end(); ?>

</div>
