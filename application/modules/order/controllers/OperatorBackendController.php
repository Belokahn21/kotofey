<?php

namespace app\modules\order\controllers;

use app\modules\order\models\entity\Order;
use app\modules\site\controllers\MainBackendController;
use app\modules\user\models\entity\User;

class OperatorBackendController extends MainBackendController
{
    public function actionIndex()
    {
        $user_id = \Yii::$app->request->get('user_id', \Yii::$app->user->id);
        $modelQuery = Order::find()->where(['manager_id' => $user_id]);
        $user = User::findOne(\Yii::$app->request->get('manager_id', $user_id));

        return $this->render('index', [
            'modelQuery' => $modelQuery,
            'user' => $user,
        ]);
    }
}