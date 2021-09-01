<?php
/* @var $model \app\modules\reviews\models\entity\Reviews
 * @var $product_id integer
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="review-form">
    <?php $form = ActiveForm::begin([
        'action' => Url::to(['/reviews/reviews/create'])
    ]); ?>
    <?= $form->field($model, 'product_id')->hiddenInput(['value' => $product_id])->label(false) ?>
    <?= $form->field($model, 'rate')->dropDownList($model->getRates(), ['prompt' => 'Как вы оцениваете товар ?']); ?>

    <div class="row">
        <div class="col-6"><?= $form->field($model, 'phone')->textInput(); ?></div>
        <div class="col-6"><?= $form->field($model, 'email')->textInput(); ?></div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-12"><?= $form->field($model, 'text')->textarea(); ?></div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-6"><?= $form->field($model, 'pluses')->textarea(); ?></div>
        <div class="col-12 col-sm-6"><?= $form->field($model, 'minuses')->textarea(); ?></div>
    </div>
    <?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
    <?php ActiveForm::end(); ?>
</div>
