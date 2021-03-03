<?php

namespace app\modules\basket\controllers;

use app\modules\basket\models\entity\Basket;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\order\models\entity\OrdersItems;
use yii\helpers\Json;
use yii\rest\Controller;
use yii\web\HttpException;

class RestController extends Controller
{
    protected function verbs()
    {
        return [
            'add' => ['POST'],
            'delete' => ['DELETE'],
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
//        $data = Json::decode(file_get_contents('php://input'));
        $data = \Yii::$app->request->post();

        $product_id = $data['product_id'];
        $count = $data['count'];

        $product = Product::find()->where(['id' => $product_id, 'status_id' => Product::STATUS_ACTIVE])->one();
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
        $basketItem->price = $product->getPrice();
        if ($discount = $product->getDiscountPrice()) $basketItem->discount_price = $discount;
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

    public function actionGetCheckout()
    {
        $data = [];

//        foreach (Product::find()->limit(5)->all() as $product) {
//            $data[] = [
//                'id' => $product->id,
//                'name' => $product->name,
//                'price' => $product->price,
//                'article' => $product->article,
//                'detailUrl' => ProductHelper::getDetailUrl($product),
//                'imageUrl' => ProductHelper::getImageUrl($product),
//            ];
//        }

        foreach (Basket::findAll() as $basketItem) {
            $data[] = [
                'id' => $basketItem->product->id,
                'name' => $basketItem->product->name,
                'price' => $basketItem->product->price,
                'article' => $basketItem->product->article,
                'detailUrl' => ProductHelper::getDetailUrl($basketItem->product),
                'imageUrl' => ProductHelper::getImageUrl($basketItem->product),
            ];
        }

        return Json::encode($data);
    }

    public function actionDelete($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $basket = new Basket();
        $basket->delete($id);

        return Json::encode([
            'status' => 200,
            'count' => Basket::count()
        ]);
    }
}
