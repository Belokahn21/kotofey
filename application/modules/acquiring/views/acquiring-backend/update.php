<?php
/* @var $this \yii\web\View
 * @var $model \app\modules\order\models\entity\Order
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = \app\modules\seo\models\tools\Title::show('Оплата по заказу #' . $model->order_id);
?>
<?php $form = ActiveForm::begin(); ?>
<?= Html::submitButton('Выполнить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end(); ?>
