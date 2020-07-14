<?php

namespace app\modules\basket\controllers;

use app\models\tool\Debug;
use app\modules\basket\models\entity\Basket;
use app\modules\catalog\models\entity\Product;
use app\modules\order\models\entity\OrdersItems;
use yii\helpers\Json;
use yii\rest\Controller;
use yii\web\HttpException;

class RestController extends Controller
{
    protected function verbs()
    {
        return [
            'add' => ['PUT']
        ];
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
            ],
        ];
    }

    public function actionAdd()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = Json::decode(file_get_contents('php://input'));

        $product_id = $data['product_id'];
        $count = $data['count'];

        $product = Product::findOne($product_id);
        if (!$product) {
            throw new HttpException(404, 'Товар не найден');
        }

        if (!$product->vitrine) {
            if ($product->count - $count <= 0) {
                return false;
            }
        }

        $basketItem = new OrdersItems();
        $basketItem->product_id = $product->id;
        $basketItem->count = $count;
        $basketItem->name = $product->name;
        $basketItem->price = $product->price;
        $basketItem->purchase = $product->purchase;

        $basket = new Basket();
        if ($basket->exist($basketItem->product_id)) {
            $basket->update($basketItem, $count);
        } else {
            $basket->add($basketItem);
        }

        return Json::encode([
            'status' => 200,
            'count' => Basket::count()
        ]);
    }
}
