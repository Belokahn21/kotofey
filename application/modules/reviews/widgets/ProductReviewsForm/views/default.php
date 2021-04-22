<?php
/* @var $model \app\modules\reviews\models\entity\Reviews
 * @var $product_id integer
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php $form = ActiveForm::begin([
    'action' => Url::to(['/reviews/reviews/create'])
]); ?>
<?= $form->field($model, 'product_id')->hiddenInput(['value' => $product_id])->label(false) ?>
<?= $form->field($model, 'rate')->dropDownList([1, 2, 3, 4, 5]); ?>
<?= $form->field($model, 'text')->textarea(); ?>
<?= Html::submitButton('Добавить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end(); ?>
