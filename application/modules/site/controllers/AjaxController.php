<?php

namespace app\modules\site\controllers;

use app\modules\site\models\helpers\ProductMarkupHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Cookie;

class AjaxController extends Controller
{
    public function actionSaveProductMark($mark)
    {

        $cookies = \Yii::$app->response->cookies;
        $cookies->add(new Cookie([
            'name' => ProductMarkupHelper::COOKIE_KEY_MARKUP,
            'value' => $mark
        ]));


        return Json::encode(\Yii::$app->request->cookies->getValue(ProductMarkupHelper::COOKIE_KEY_MARKUP) == $mark);
    }
}