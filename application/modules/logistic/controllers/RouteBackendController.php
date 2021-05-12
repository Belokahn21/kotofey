<?php

namespace app\modules\logistic\controllers;

use app\modules\logistic\models\forms\LogisticForm;
use app\modules\order\models\entity\Order;
use app\modules\site\controllers\MainBackendController;
use app\widgets\notification\Alert;
use yii\web\Controller;

class RouteBackendController extends MainBackendController
{
    public function actionIndex()
    {
        $model = new LogisticForm();
        $models = Order::find()->leftJoin('order_date', 'order.id=order_date.order_id')
            ->where(['is_close' => false, 'is_cancel' => false])
            ->where(['order_date.date' => date('d.m.Y')])
            ->orderBy(['id' => SORT_ASC]);
        $models = $models->all();


        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate() && $model->start()) {
                    Alert::setSuccessNotify('Заказ №' . $model->order_id . ' успешно завершен');
                    return $this->refresh();
                }
            }
        }

        return $this->render('index', [
            'models' => $models,
            'model' => $model,
        ]);
    }
}
