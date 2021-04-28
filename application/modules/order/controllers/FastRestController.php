<?php

namespace app\modules\order\controllers;

use app\modules\order\models\entity\Order;
use yii\rest\Controller;

class FastRestController extends Controller
{
    public function actionCreate()
    {
        $data = \Yii::$app->request->post();

        $model = new Order(['scenario' => Order::SCENARIO_FAST]);

        $model->load($data);

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