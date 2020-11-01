<?php

namespace app\modules\export\controllers;


use app\modules\catalog\models\entity\Category;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\ProductPropertiesValues;
use app\modules\site\models\tools\Debug;
use yii\web\Controller;

class AliexpressController extends Controller
{
    public function actionIndex()
    {
        $categories = Category::find()->all();
        $offers = Product::find()
            ->select(['product.id', 'product.name', 'product.price', 'product.purchase', 'product.media_id', 'product.status_id', 'product.is_ali'])
            ->rightJoin('product_properties_values as ppv', 'ppv.product_id = product.id')
            ->where(['product.status_id' => Product::STATUS_ACTIVE])
            ->where(['product.id' => 423])
            ->andWhere(['product.is_ali' => 1])
            ->andWhere(['in', 'ppv.property_id', [16, 17, 18]])
            ->andWhere(['is not', 'ppv.value', null]);

        $offers = $offers->all();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        \Yii::$app->response->headers->add('Content-Type', 'text/xml');


        $response = $this->renderPartial('index', [
            'offers' => $offers,
            'categories' => $categories
        ]);

        return $response;
    }

    public function getXmlHead()
    {
        return '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL . '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">' . PHP_EOL;
    }
}