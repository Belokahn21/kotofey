<?php
/* @var $model \app\modules\reviews\models\entity\Reviews
 * @var $product_id integer
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="review-form">

    <?php if (Yii::$app->user->isGuest): ?>
        <div class="review-no-login">
            Чтобы оставлять комментарии вы должны быть авторизованы на сайте.
        </div>
    <?php else: ?>
        <?php $form = ActiveForm::begin([
            'action' => Url::to(['/reviews/reviews/create'])
        ]); ?>
        <?= $form->field($model, 'product_id')->hiddenInput(['value' => $product_id])->label(false) ?>
        <?= $form->field($model, 'rate')->dropDownList($model->getRates(), ['prompt' => 'Как вы оцениваете товар ?']); ?>
        <?= $form->field($model, 'text')->textarea(); ?>
        <?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
        <?php ActiveForm::end(); ?>
    <?php endif; ?>
</div>
