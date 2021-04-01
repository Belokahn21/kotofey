<?php

namespace app\modules\acquiring\controllers;


use app\modules\acquiring\models\entity\AcquiringOrder;
use yii\rest\Controller;

class OrderRestController extends Controller
{
    public $modelClass = '';

    public function actionCreate()
    {
        $data = \Yii::$app->request->post();

        $model = new AcquiringOrder();
        $model->order_id = $data['order_id'];
        $model->identifier_id = $data['sber_order_id'];

        if (!$model->validate() || !$model->save()) {
            return $this->asJson([
                'status' => 500,
                'error' => $model->getErrors()
            ]);
        }

        return $this->asJson([
            'status' => 200
        ]);

    }
}