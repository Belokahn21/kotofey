<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\tool\seo\Title;
use yii\helpers\Url;

/* @var $users \app\models\entity\User[]
 * @var $model \app\modules\order\models\entity\Order
 * @var $deliveries \app\models\entity\Delivery[]
 * @var $payments \app\models\entity\Payment[]
 * @var $status \app\modules\order\models\entity\OrderStatus[]
 * @var $itemsModel \app\modules\order\models\entity\OrdersItems
 */

$this->title = Title::showTitle("Обновить заказ:" . $model->id);
?>
<?= Html::a('Назад', Url::to(['index']), ['class' => 'btn-main']) ?>
    <h1>Обновить заказ: <?= $model->id; ?></h1>
<?php $form = ActiveForm::begin() ?>
<?= $this->render('_form', [
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