<?php

namespace app\modules\basket\controllers;

use app\modules\basket\models\entity\Basket;
use app\modules\basket\models\entity\BasketItem;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\order\models\entity\OrdersItems;
use app\modules\site\models\tools\Debug;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\web\HttpException;


class RestController extends ActiveController
{
    public $modelClass = 'app\modules\basket\models\entity\Basket';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['create'], $actions['delete'], $actions['update']);

        return $actions;
    }


    public function behaviors()
    {
        $behaviors = parent::behaviors();

        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];

        return $behaviors;
    }

    public function actionCreate()
    {
        $data = \Yii::$app->request->post();

        $product_id = $data['product_id'];
        $count = $data['count'];

        $product = Product::find()->where(['id' => $product_id, 'status_id' => Product::STATUS_ACTIVE])->one();
        if (!$product) throw new HttpException(404, 'Товар не найден');


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

        $basket = new $this->modelClass();
        if ($basket->exist($basketItem->product_id)) {
            $basket->update($basketItem, $count);
        } else {
            $basket->add($basketItem);
        }

        return [
            'status' => 200,
            'count' => Basket::count()
        ];
    }

    public function actionUpdate()
    {
        $models = Json::decode(file_get_contents('php://input'));

        foreach ($models as $model) {
            $orderItemModel = new OrdersItems();
            $orderItemModel->setAttributes($model);

            $orderItemModel->product_id = $model['id'];

            if ($orderItemModel->validate()) {
                $basket = new Basket();
                $basket->update($orderItemModel, $orderItemModel->count);
            }
        }

        return $models;
    }

    public function actionIndex()
    {
        $data = [];

//        foreach (Product::find()->limit(5)->all() as $product) {
//            $data[] = [
//                'id' => $product->id,
//                'name' => $product->name,
//                'price' => $product->price,
//                'count' => rand(1, 10),
//                'article' => $product->article,
//                'detailUrl' => ProductHelper::getDetailUrl($product),
//                'imageUrl' => ProductHelper::getImageUrl($product),
//            ];
//        }

        /* @var $basketItem BasketItem */
        foreach ($this->modelClass::findAll() as $basketItem) {
            $data[] = [
                'id' => $basketItem->product->id,
                'name' => $basketItem->product->name,
                'price' => $basketItem->product->getDiscountPrice() ?: $basketItem->product->getPrice(),
                'count' => $basketItem->getCount(),
                'article' => $basketItem->product->article,
                'detailUrl' => ProductHelper::getDetailUrl($basketItem->product),
                'imageUrl' => ProductHelper::getImageUrl($basketItem->product),
            ];
        }

        $response = [
            'status' => 200,
            'items' => $data
        ];


        return $response;
    }

    public function actionDelete($id)
    {
        $model = new $this->modelClass();

        if ($model->delete($id) === false) {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }

        \Yii::$app->getResponse()->setStatusCode(200);
    }
}
