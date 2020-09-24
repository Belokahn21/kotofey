<?php

namespace app\modules\catalog\controllers;


use app\models\tool\parser\ParseProvider;
use app\models\tool\parser\ProviderFactory;
use yii\helpers\Json;
use yii\web\Controller;

class AjaxController extends Controller
{
    public function actionCatalogFillFromVendor()
    {
        $data = \Yii::$app->request->post();

        $factory = new ParseProvider($data['link']);
        $factory->contract();

        return Json::encode($factory->getInfo());
    }
}