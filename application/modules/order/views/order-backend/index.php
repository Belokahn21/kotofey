<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\tool\seo\Title;
use yii\grid\GridView;
use app\modules\user\models\entity\User;
use yii\helpers\Url;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\order\widgets\group_buy\GroupBuyWidget;
use yii\helpers\ArrayHelper;
use app\modules\order\models\entity\Order;

/* @var $users \app\modules\user\models\entity\User[]
 * @var $model \app\modules\order\models\entity\Order
 * @var $deliveries app\modules\delivery\models\entity\Delivery[]
 * @var $payments \app\modules\payment\models\entity\Payment[]
 * @var $status \app\modules\order\models\entity\OrderStatus[]
 * @var $itemsModel \app\modules\order\models\entity\OrdersItems
 */

$this->title = Title::showTitle("Заказы");
?>
    <h1 class="title">Заказы</h1>
<?= GroupBuyWidget::widget(); ?>
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
<?= Html::submitButton('Добавить', ['class' => 'btn-main']) ?>
<?php ActiveForm::end() ?>
    <h2 class="title">Список заказов</h2>
<?php echo GridView::widget([
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
	'emptyText' => 'Закзаы отсутствуют',
	'columns' => [
		'id',
		[
			'attribute' => 'status',
			'value' => function ($model) {
				return $model->getStatus();
			}
		],
		[
			'attribute' => 'phone',
			'format' => 'raw',
			'filter' => ArrayHelper::map(Order::find()->select(['phone'])->all(), 'phone', 'phone'),
			'value' => function ($model) {
				if ($model->phone) {
					return Html::a($model->phone, 'tel:' . $model->phone);
				}
			}
		],
//		[
//			'attribute' => 'delivery_id',
//			'filter' => ArrayHelper::map(Delivery::find()->all(), 'id', 'nameF'),
//			'value' => function ($model) {
//				if ($model->delivery_id > 0) {
//					return Delivery::findOne($model->delivery_id)->name;
//				} else {
//					return "Не указано";
//				}
//			}
//		],
//		[
//			'attribute' => 'payment_id',
//			'filter' => ArrayHelper::map(Payment::find()->all(), 'id', 'nameF'),
//			'value' => function ($model) {
//				if ($model->payment_id > 0) {
//					return Payment::findOne($model->payment_id)->name;
//				} else {
//					return "Не указано";
//				}
//			}
//		],
		[
			'attribute' => 'is_paid',
			'format' => 'raw',
			'value' => function ($model) {
				return ($model->is_paid == true) ? Html::tag('span', 'Оплачено', ['class' => 'green']) : Html::tag('span', 'Не оплачено', ['class' => 'red']);
			}
		],
		[
			'attribute' => 'user_id',
			"format" => 'raw',
			'filter' => ArrayHelper::map(User::find()->all(), 'id', 'email'),
			'value' => function ($model) {
				if ($model->user_id) {
					return Html::a(User::findOne($model->user_id)->display, Url::to(['admin/user', 'id' => $model->user_id]));
				}
			}
		],
		[
			'attribute' => 'cash',
			'format' => 'raw',
			'value' => function ($model) {
				return OrderHelper::orderSummary($model->id) . ' (<span class="green">+' . OrderHelper::marginality($model->id) . '</span>)';
			}
		],
		'promo_code',
		[
			'label' => 'Итого к оплате',
			'format' => 'raw',
			'value' => function ($model) {
				$out_summ = OrderHelper::orderSummary($model->id);
				return $out_summ;
			}
		],
		[
			'attribute' => 'created_at',
			'value' => function ($model) {
				return date("d.m.Y", $model->created_at);
			}
		],
		[
			'class' => 'yii\grid\ActionColumn',
			'buttons' => [
				'view' => function ($url, $model, $key) {
					return Html::a('<i class="fas fa-file-alt"></i>', Url::to(["order-report", 'id' => $key]));
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
