<?php


namespace app\modules\payment\controllers;


use app\modules\site\models\tools\Debug;
use yii\web\Controller;

class PaymentController extends Controller
{
    public function actionSuccess()
    {
        Debug::printFile(\Yii::$app->request->post());
        Debug::printFile(\Yii::$app->request->get());
        return $this->render('result');
    }

    public function actionFail()
    {
        Debug::printFile(\Yii::$app->request->post());
        Debug::printFile(\Yii::$app->request->get());
        return $this->render('result');
    }
}