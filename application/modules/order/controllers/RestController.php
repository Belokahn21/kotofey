<?php


namespace app\modules\order\controllers;

use app\modules\order\models\entity\OrdersItems;
use app\modules\order\models\entity\OrderDate;
use app\modules\order\models\entity\Order;
use yii\rest\Controller;

class RestController extends Controller
{
    public $modelClass = 'app\modules\order\models\entity\Order';

//    public function behaviors()
//    {
//        $behaviors = parent::behaviors();
//        $behaviors['authenticator'] = HttpBasicAuth::className();
//
//        return $behaviors;
//    }

    protected function verbs()
    {
        return [
            'index' => ['GET'],
            'show' => ['GET'],
            'create' => ['POST'],
            'delete' => ['DELETE'],
        ];
    }

    public function actionIndex()
    {
        return array(
            'status' => 200,
            'items' => $this->modelClass::find()->all()
        );
    }

    public function actionShow($id)
    {
        return array(
            'status' => 200,
            'items' => $this->modelClass::findOne($id)
        );
    }

    public function actionCreate()
    {
        $order = new $this->modelClass(['scenario' => Order::SCENARIO_CLIENT_BUY]);
        $orderDate = new OrderDate();
        $items = new OrdersItems();
        $response = [
            'status' => 200,
        ];

        if (!$order->load(\Yii::$app->request->post())) {
            $response['status'] = 500;
            $response['errors'] = 'Данные в модель Order не были загружены';
            return $response;
        }

        if (!$order->validate() || !$order->save()) {
            $response['status'] = 510;
            $response['errors'] = $order->getErrors();
            return $response;
        }

        $items->order_id = $order->id;
        if (!$items->saveItems()) {
            $response['status'] = 530;
            $response['errors'] = $items->getErrors();
            return $response;
        }


        return $response;
    }

    public function actionDelete($id)
    {
        $model = $this->modelClass::findOne($id);

        if (!$model) return array(
            'status' => 500,
            'error' => 'Элемент не найден'
        );

        if ($model->delete()) {
            return [
                'status' => 500,
                'error' => 'Ошибка при удалении элемента',
                'errors' => $model->getErrors()
            ];
        }


        return [
            'status' => 200
        ];
    }


//    public $modelClass = 'app\modules\order\models\entity\Order';
//
//    protected function verbs()
//    {
//        return [
//            'all' => ['GET'],
//            'create' => ['POST'],
//            'delete' => ['DELETE'],
//        ];
//    }
//
//    public function behaviors()
//    {
//        return [
//            'corsFilter' => [
//                'class' => \yii\filters\Cors::className(),
//            ],
//        ];
//    }
//
//    public function actionCreate()
//    {
//        $order = new $this->modelClass(['scenario' => Order::SCENARIO_CLIENT_BUY]);
//        $orderDate = new OrderDate();
//        $items = new OrdersItems();
//        $response = [
//            'status' => 200,
//        ];
//
//        if (!$order->load(\Yii::$app->request->post())) {
//            $response['status'] = 500;
//            $response['errors'] = 'Данные в модель Order не были загружены';
//            return $response;
//        }
//
//        if (!$order->validate() || !$order->save()) {
//            $response['status'] = 510;
//            $response['errors'] = $order->getErrors();
//            return $response;
//        }
//
//        $items->order_id = $order->id;
//        if (!$items->saveItems()) {
//            $response['status'] = 530;
//            $response['errors'] = $items->getErrors();
//            return $response;
//        }
//
//
//        return $response;
//    }
//
//    public function actionAll()
//    {
//        return $this->modelClass::find()->all();
//    }
}