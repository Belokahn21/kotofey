<?php

namespace app\modules\order\controllers;

use app\modules\order\models\entity\Order;
use app\modules\order\models\forms\OperatorReportFilterForm;
use app\modules\site\controllers\MainBackendController;
use app\modules\user\models\entity\User;

class OperatorBackendController extends MainBackendController
{
    public function actionIndex()
    {
        $filterModel = new OperatorReportFilterForm();
        $manager_id = \Yii::$app->request->get('manager_id', \Yii::$app->user->id);
        $orderQuery = Order::find();
        $user = User::findOne($manager_id);


        $filterModel->load(\Yii::$app->request->get());
        $filterModel->applyFilter($orderQuery);

        return $this->render('index', [
            'orderQuery' => $orderQuery,
            'user' => $user,
            'filterModel' => $filterModel,
        ]);
    }
}