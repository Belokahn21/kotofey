<?php

namespace app\modules\basket\controllers;


use app\modules\basket\models\entity\Basket;
use app\widgets\notification\Alert;
use yii\web\Controller;

class BasketController extends Controller
{
    public function actionClear()
    {
        Basket::getInstance()->clear();
        Alert::setSuccessNotify("Корзина очищена!");
        return $this->redirect(['/']);
    }
}