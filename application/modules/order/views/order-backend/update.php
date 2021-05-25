<?php

use app\modules\acquiring\models\entity\AcquiringOrder;
use app\modules\order\widgets\CallCenter\CallCenterWidget;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\modules\seo\models\tools\Title;
use yii\helpers\Url;

/* @var $users \app\modules\user\models\entity\User[]
 * @var $model \app\modules\order\models\entity\Order
 * @var $deliveries app\modules\delivery\models\entity\Delivery[]
 * @var $payments \app\modules\payment\models\entity\Payment[]
 * @var $status \app\modules\order\models\entity\OrderStatus[]
 * @var $itemsModel \app\modules\order\models\entity\OrdersItems
 * @var $trackForm \app\modules\order\models\entity\OrderTracking
 */

$this->title = Title::show("Обновить заказ: " . $model->id);
?>
    <div class="title-group">
        <h1>Обновить заказ: #<?= $model->id; ?></h1>
        <?= Html::a('Назад', Url::to(['index']), ['class' => 'btn-main']) ?>
        <?= Html::a('Удалить', Url::to(['delete', 'id' => $model->id]), ['class' => 'btn-main']) ?>
        <?= Html::a('Через кабинет пользователя', '/profile/order/' . $model->id . '/', ['class' => 'btn-main', 'target' => 'blank']) ?>
        <?= CallCenterWidget::widget([
            'order_id' => $model->id
        ]); ?>
        <?php if (!AcquiringOrder::findOne(['order_id' => $model->id]) && $model->delivery_id == 1): ?>
            <?= Html::a('Ининцилизировать оплату', Url::to(['payment-link', 'id' => $model->id]), ['class' => 'btn-main']) ?>
        <?php endif; ?>
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
    'trackForm' => $trackForm,
]); ?>
<?= Html::submitButton('Обновить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end() ?>