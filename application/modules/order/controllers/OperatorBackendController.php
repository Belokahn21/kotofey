<?php

namespace app\modules\order\controllers;

use app\modules\order\models\entity\Order;
use app\modules\site\controllers\MainBackendController;
use app\modules\user\models\entity\User;

class OperatorBackendController extends MainBackendController
{
    public function actionIndex()
    {
        $modelQuery = Order::find()->where(['manager_id' => \Yii::$app->user->id]);
        $user = User::findOne(\Yii::$app->request->get('manager_id', \Yii::$app->user->identity->id));

        return $this->render('index', [
            'modelQuery' => $modelQuery,
            'user' => $user,
        ]);
    }
}