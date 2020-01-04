<?php

namespace app\controllers;

use Yii;
use app\models\entity\Product;
use yii\web\Controller;

class YandexController extends Controller
{
    public $layout = false;

    public function actionExport()
    {
        \Yii::$app->response->format = \Yii\web\Response::FORMAT_XML;
        $this->renderPartial('export');
    }
}