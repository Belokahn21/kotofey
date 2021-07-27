<?php

namespace app\modules\export\controllers;


use app\modules\catalog\models\entity\ProductCategory;
use app\modules\catalog\models\entity\Product;
use yii\web\Controller;

class AliexpressController extends Controller
{
    public function actionIndex()
    {
        set_time_limit(0);
        $categories = ProductCategory::find()->all();
        $module = \Yii::$app->getModule('export');
        $offers = \Yii::$app->cache->getOrSet('ali:export', function () {
            return Product::find()->where(['status_id' => Product::STATUS_ACTIVE])->all();
        });


        \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        \Yii::$app->response->headers->add('Content-Type', 'application/xml');


        $response = $this->renderPartial('index', [
            'offers' => $offers,
            'categories' => $categories,
            'module' => $module,
        ]);

        return $response;
    }

    public function getXmlHead()
    {
        return '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL . '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">' . PHP_EOL;
    }
}