<?php

namespace app\modules\export\controllers;

use app\modules\catalog\models\entity\ProductCategory;
use app\modules\catalog\models\entity\Product;
use app\modules\vendors\models\entity\Vendor;
use yii\web\Controller;

class YmlController extends Controller
{
    public function actionIndex()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        \Yii::$app->response->headers->add('Content-Type', 'application/xml');

        $module = \Yii::$app->getModule('export');


        $offers = \Yii::$app->cache->getOrSet('yml-offers-market', function () {
            return Product::find()->where(['status_id' => Product::STATUS_ACTIVE, 'vendor_id' => Vendor::VENDOR_ID_ROYAL])->all();
        });

        $categories = \Yii::$app->cache->getOrSet('yml-categories-market', function () {
            return ProductCategory::find()->all();
        });


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
