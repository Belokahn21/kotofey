<?php

namespace app\modules\order\controllers;

use app\modules\order\models\entity\Order;
use app\modules\site\controllers\MainBackendController;
use app\modules\user\models\entity\User;

class OperatorBackendController extends MainBackendController
{
    public function actionIndex()
    {
        $manager_id = \Yii::$app->request->get('manager_id', \Yii::$app->user->id);
        $orderQuery = Order::find()->where(['manager_id' => $manager_id])->andWhere('created_at >= UNIX_TIMESTAMP(LAST_DAY(CURDATE()) + INTERVAL 1 DAY - INTERVAL 1 MONTH) AND created_at <  UNIX_TIMESTAMP(LAST_DAY(CURDATE()) + INTERVAL 1 DAY)');
        $user = User::findOne($manager_id);

        return $this->render('index', [
            'orderQuery' => $orderQuery,
            'user' => $user,
        ]);
    }
}