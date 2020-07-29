<?php

namespace app\modules\order\controllers;


use app\modules\basket\models\entity\Basket;
use app\modules\order\models\entity\OrderDate;
use app\modules\payment\models\entity\Payment;
use app\modules\order\models\service\DeliveryTimeService;
use app\modules\delivery\models\entity\Delivery;
use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrdersItems;
use app\widgets\notification\Alert;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;

class OrderController extends Controller
{
//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    [
//                        'actions' => ['checkout'],
//                        'allow' => true,
//                        'matchCallback' => function ($rule, $action) {
//                            return Basket::count() > 0;
//                        }
//                    ]
//                ],
//            ]
//        ];
//    }

	public function actionCreate()
	{
		$order = new Order(['scenario' => Order::SCENARIO_CLIENT_BUY]);
		$payments = Payment::findAll(['active' => true]);
		$deliveries = Delivery::findAll(['active' => true]);
		$order_date = new OrderDate();
		$delivery_time = new DeliveryTimeService();

		if (\Yii::$app->request->isPost) {
			$transaction = \Yii::$app->db->beginTransaction();

			if ($order->load(\Yii::$app->request->post())) {

				if (!\Yii::$app->user->isGuest) {
					$order->user_id = \Yii::$app->user->id;
				}

				if (!$order->validate()) {
					print_r($order->getErrors());
					$transaction->rollBack();
					return false;

				}
				if (!$order->save()) {
					Alert::setErrorNotify("Ошибка при создании заказа.");
					$transaction->rollBack();
					return false;

				}

				// save order date delivery
//                if ($order_date->load(\Yii::$app->request->post())) {
//                    $order_date->order_id = $order->id;
//                    if (!$order_date->validate()) {
//                        $transaction->rollBack();
//                        Alert::setErrorNotify('Ошибка при создании заказа. Не корректная дата заказа.');
//                        return false;
//                    }
//
//                    if (!$order_date->save()) {
//                        $transaction->rollBack();
//                        Alert::setErrorNotify('Ошибка при создании заказа. Дата доставки заказа не сохранена.');
//                        return false;
//                    }
//                }

				// save products
				$items = new OrdersItems();
				$items->order_id = $order->id;

				if (!$items->saveItems()) {
					Alert::setErrorNotify("Товары не были сохранены. Заказ не создан.");
					$transaction->rollBack();
					return false;
				}
			}


			$transaction->commit();
			Alert::setSuccessNotify('Заказ успешно создан.');
			return $this->redirect('/');
		}

		return $this->render('create', [
			'order' => $order,
			'deliveries' => $deliveries,
			'payments' => $payments,
//            'delivery_time' => $delivery_time,
//            'order_date' => $order_date,
		]);
	}

	public function actionView($id)
	{
		$order = Order::findOne($id);
		if (!$order) {
			throw new HttpException(404, 'Такого заказа не существует');
		}

		if (!$order->hasAccess()) {
			throw new ForbiddenHttpException('Доступ к заказу запрещён');
		}

		$items = OrdersItems::find()->where(['order_id' => $order->id])->all();

		return $this->render('view', [
			'order' => $order,
			'items' => $items,
		]);
	}
}