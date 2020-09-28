<?php

use app\modules\order\widgets\call_center\CallCenterWidget;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\tool\seo\Title;
use yii\helpers\Url;

/* @var $users \app\modules\user\models\entity\User[]
 * @var $model \app\modules\order\models\entity\Order
 * @var $deliveries app\modules\delivery\models\entity\Delivery[]
 * @var $payments \app\modules\payment\models\entity\Payment[]
 * @var $status \app\modules\order\models\entity\OrderStatus[]
 * @var $itemsModel \app\modules\order\models\entity\OrdersItems
 */

$this->title = Title::showTitle("Обновить заказ: " . $model->id);
?>
    <div class="title-group">
        <h1>Обновить заказ: #<?= $model->id; ?></h1>
        <?= Html::a('Назад', Url::to(['index']), ['class' => 'btn-main']) ?>
        <?= Html::a('Удалить', Url::to(['delete', 'id' => $model->id]), ['class' => 'btn-main']) ?>
        <?= CallCenterWidget::widget([
            'order_id' => $model->id
        ]); ?>
    </div>
<?php if (!$model->isNewRecord): ?>
    <?php //todo: лень вывести данные цифровые ?>
<?php endif; ?>
<?php $form = ActiveForm::begin() ?>
<?= $this->render('_form', [
    'dateDelivery' => $dateDelivery,
    'itemsModel' => $itemsModel,
    'users' => $users,
    'model' => $model,
    'deliveries' => $deliveries,
    'payments' => $payments,
    'status' => $status,
    'form' => $form,
]); ?>
<?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end() ?>