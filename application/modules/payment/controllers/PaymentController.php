<?php


namespace app\modules\payment\controllers;


use yii\web\Controller;

class PaymentController extends Controller
{
    public function actionReturnUrl()
    {
        return $this->render('return-url');
    }
}