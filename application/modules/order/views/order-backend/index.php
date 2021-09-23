<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\seo\models\tools\Title;
use app\modules\order\models\entity\Customer;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\order\widgets\GroupBuy\GroupBuyWidget;
use app\modules\order\models\entity\OrderStatus;

/* @var $users \app\modules\user\models\entity\User[]
 * @var $model \app\modules\order\models\entity\Order
 * @var $deliveries app\modules\delivery\models\entity\Delivery[]
 * @var $payments \app\modules\payment\models\entity\Payment[]
 * @var $status \app\modules\order\models\entity\OrderStatus[]
 * @var $itemsModel \app\modules\order\models\entity\OrdersItems
 * @var $trackForm \app\modules\order\models\entity\OrderTracking
 */

$this->title = Title::show("Заказы");
?>
    <div class="title-group">
        <h1>Заказы</h1>
        <?= GroupBuyWidget::widget(); ?>
        <div class="repeat-order-react"></div>
        <?= Html::a('Выгрузка Email', Url::to(['order-backend/export']), ['class' => 'btn-main', 'target' => '_blank']); ?>
        <?= Html::a('Карточки клиентов', Url::to(['customer-backend/index']), ['class' => 'btn-main', 'target' => '_blank']); ?>
    </div>
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
<?= Html::submitButton('Добавить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end() ?>
    <h2 class="title">Список заказов</h2>
<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'emptyText' => 'Закзаы отсутствуют',
    'columns' => [
        'id',
        'email',
        [
            'attribute' => 'operator_id',
            'label' => 'Оператор',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->manager->email;
            }
        ],
        [
            'attribute' => 'status',
            'filter' => ArrayHelper::map(OrderStatus::find()->all(), 'id', 'name'),
            'value' => function ($model) {
                return OrderHelper::getStatus($model);
            }
        ],
        [
            'attribute' => 'phone',
            'format' => 'raw',
            'filter' => ArrayHelper::map(Customer::find()->all(), 'phone', 'name'),
            'value' => function ($model) {
                if ($model->phone) {
                    return Html::a($model->phone, 'tel:' . $model->phone, ['class' => 'js-phone-mask']);
                }
                return "Не указан";
            }
        ],
        [
            'attribute' => 'is_paid',
            'filter' => ['Не оплачено', 'Оплачено'],
            'format' => 'raw',
            'value' => function ($model) {
                return ($model->is_paid == true) ? Html::tag('span', 'Оплачено', ['class' => 'green']) : Html::tag('span', 'Не оплачено', ['class' => 'red']);
            }
        ],
        [
            'attribute' => 'cash',
            'format' => 'raw',
            'value' => function ($model) {
                $sum = OrderHelper::orderSummary($model);
                $marge = OrderHelper::marginality($model);

                if ($marge > 0) {
                    return $sum . ' (<span class="green">+' . $marge . '</span>)';
                }

                return $sum . ' (<span class="red">' . $marge . '</span>)';
            }
        ],
        [
            'attribute' => 'created_user_id',
        ],
        [
            'attribute' => 'updated_user_id',
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-file-alt"></i>', Url::to(["report", 'id' => $key]));
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="far fa-eye"></i>', Url::to(["update", 'id' => $key]));
                },
                'delete' => function ($url, $model, $key) {
//                    if ($key) {
//                        return Html::a('<i class="fas fa-trash-alt"></i>',
//                            Url::to(["admin/order", 'id' => $key, 'action' => 'delete']));
//                    }
                }
            ]
        ],
    ],
]);
