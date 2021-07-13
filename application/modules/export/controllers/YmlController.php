<?php

namespace app\modules\export\controllers;

use app\modules\catalog\models\entity\ProductCategory;
use app\modules\catalog\models\entity\Offers;
use yii\web\Controller;

class YmlController extends Controller
{
    public function actionIndex()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        \Yii::$app->response->headers->add('Content-Type', 'application/xml');
        $categories = ProductCategory::find()->all();
        $offers = Offers::find()->where(['status_id' => Offers::STATUS_ACTIVE])->all();
        $module = \Yii::$app->getModule('export');

        $response = $this->renderPartial('index', [
            'offers' => $offers,
            'categories' => $categories,
            'module' => $module
        ]);

        return $response;
    }

    public function getXmlHead()
    {
        return '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL . '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">' . PHP_EOL;
    }
}
