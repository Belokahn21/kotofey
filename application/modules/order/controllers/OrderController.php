<?php

namespace app\modules\order\controllers;


use app\modules\basket\models\entity\Basket;
use app\modules\bonus\models\helper\BonusHelper;
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
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['view'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
//						'matchCallback' => function ($rule, $action) {
//							return Basket::count() > 0;
//						}
                    ],
                ],
            ]
        ];
    }

    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }

    public function actionCreate()
    {
        if (!Basket::count()) return $this->redirect(['/']);


        $order = new Order(['scenario' => Order::SCENARIO_CLIENT_BUY]);
        $payments = Payment::findAll(['active' => true]);
        $deliveries = Delivery::findAll(['active' => true]);

        if (\Yii::$app->request->isPost) {
            $transaction = \Yii::$app->db->beginTransaction();

            if ($order->load(\Yii::$app->request->post())) {

                if (!\Yii::$app->user->isGuest) $order->user_id = \Yii::$app->user->id;

                if (!$order->validate()) {
                    $transaction->rollBack();
                    return false;
                }

                if ($module = \Yii::$app->getModule('bonus')) {
                    if ($module->getEnable()) {
                        if ($order->bonus && $order->bonus > 0) {
                            BonusHelper::addHistory($order, $order->bonus * -1, 'Списание за заказ #' . $order->id, true);
                            $order->discount = $order->bonus * -1;
                        } else {
                            BonusHelper::applyUserBonus($order, false);
                        }
                    }
                }
                if (!$order->save()) {
                    Alert::setErrorNotify("Ошибка при создании заказа.");
                    $transaction->rollBack();
                    return false;
                }

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
            Alert::setSuccessNotify('Заказ успешно создан. В ближайшее время с вами свяжется оператор.');
            return $this->redirect('/');
        }

        return $this->render('create', [
            'order' => $order,
            'deliveries' => $deliveries,
            'payments' => $payments,
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