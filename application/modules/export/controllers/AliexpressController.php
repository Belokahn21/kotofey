<?php

namespace app\modules\export\controllers;


use app\modules\catalog\models\entity\ProductCategory;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\SaveProductPropertiesValues;
use app\modules\site\models\tools\Debug;
use yii\web\Controller;

class AliexpressController extends Controller
{
    public function actionIndex()
    {
        set_time_limit(0);
        $categories = ProductCategory::find()->all();

        $offers = \Yii::$app->cache->getOrSet('ali:export', function () {
            return Product::find()->where(['status_id' => Product::STATUS_ACTIVE]);
        });


        \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        \Yii::$app->response->headers->add('Content-Type', 'application/xml');


        $response = $this->renderPartial('index', [
            'offersBatch' => $offers,
            'categories' => $categories
        ]);

        return $response;
    }

    public function getXmlHead()
    {
        return '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL . '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">' . PHP_EOL;
    }
}