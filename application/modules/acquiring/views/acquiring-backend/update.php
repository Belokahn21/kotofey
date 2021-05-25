<?php
/* @var $this \yii\web\View
 * @var $actionForm \app\modules\acquiring\models\forms\AcquiringForm
 * @var $model \app\modules\acquiring\models\entity\AcquiringOrder
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\seo\models\tools\Title;

$this->title = Title::show('Оплата по заказу #' . $model->order_id);
?>
<div class="title-group">
    <h1><?= 'Оплата по заказу #' . $model->order_id; ?></h1>
    <?= Html::a('Удалить', \yii\helpers\Url::to(['delete'])); ?>
</div>
<?php $form = ActiveForm::begin(); ?>
<?= $form->field($actionForm, 'transaction_id')->textInput(['value' => $model->id]); ?>
<?= $form->field($actionForm, 'action')->dropDownList($actionForm->getActions(), ['prompt' => 'Выберите действие']); ?>
<?= Html::submitButton('Выполнить', ['class' => 'btn-main']); ?>
<?php ActiveForm::end(); ?>
