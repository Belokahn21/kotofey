<?php

namespace app\modules\order\controllers;

use app\modules\order\models\entity\Order;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\order\models\service\OrderService;
use app\modules\site\models\tools\Currency;
use app\modules\site\models\tools\PriceTool;
use yii\filters\Cors;
use yii\rest\ActiveController;

class RestController extends ActiveController
{
    public $modelClass = 'app\modules\order\models\entity\Order';
    public $searchModelClass = 'app\modules\order\models\search\OrderSearchForm';
    public $service;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);

        $actions['index']['dataFilter'] = [
            'class' => \yii\data\ActiveDataFilter::class,
            'searchModel' => $this->searchModelClass,
        ];
        $actions['index']['prepareDataProvider'] = function ($action) {
            $model = new $this->searchModelClass();
            $model->load(\Yii::$app->request->queryParams);
            return $model->search(\Yii::$app->request->queryParams);
        };

        return $actions;
    }

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->service = new OrderService();
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => Cors::className()
        ];
        return $behaviors;
    }

    public function actionCreate()
    {
        $response['status'] = 200;

        $model = new Order();
        $this->service->setModel($model);

        try {
            $order = $this->service->createOrder();
        } catch (\Exception $e) {
            $response['errors'] = $this->service->getErrors();
            $response['status'] = 500;
            return $response;
        }

        $response['data']['order'] = [
            'id' => $order->id,
            'status' => OrderHelper::getStatus($order),
            'delivery' => OrderHelper::getDelivery($order),
            'payment' => OrderHelper::getPayment($order),
            'created' => date('d.m.Y H:i:s', $order->created_at),
            'address' => (!$order->city ? '' : 'г. ' . $order->city) . (!$order->street ? '' : ', ул. ' . $order->street) . (!$order->number_home ? '' : ', д. ' . $order->number_home) . (!$order->entrance ? '' : ', п. ' . $order->entrance) . (!$order->floor_house ? '' : ', эт. ' . $order->floor_house) . (!$order->number_appartament ? '' : ', кв. ' . $order->number_appartament),
            'total' => PriceTool::format(OrderHelper::orderSummary($order)) . ' ' . Currency::getInstance()->show(),
        ];


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
}