<?php

namespace app\modules\basket\controllers;

use app\modules\basket\models\entity\Basket;
use app\modules\basket\models\entity\OrmBasketItem;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\catalog\models\helpers\PropertiesHelper;
use app\modules\order\models\entity\OrdersItems;
use yii\helpers\ArrayHelper;
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

        $product_id = ArrayHelper::getValue($data, 'product_id', false);
        $count = ArrayHelper::getValue($data, 'count', false);

        if (!$product_id || !$count) throw new \Exception('Не все элементы переданы.');

        $product = Product::find()->where(['id' => $product_id, 'status_id' => Product::STATUS_ACTIVE])->one();
        if (!$product) throw new HttpException(404, 'Товар не найден');


        if (!$product->vitrine) {
            if ($product->count - $count <= 0) {
                return false;
            }
        }

        $basketItem = new OrmBasketItem();
        $basketItem->setId($product->id);
        $basketItem->setProductId($product->id);
        $basketItem->setCount($count);
        $basketItem->setName($product->name);
        $basketItem->setPrice($product->getPrice());
        $basketItem->setWeight(PropertiesHelper::getProductWeight($product->id));
//        if ($discount = $product->getDiscountPrice()) $basketItem->discount_price = $discount;
//        $basketItem->purchase = $product->purchase;

        $basket = new $this->modelClass();
        if ($basket->exist($basketItem->getId())) {
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

        foreach ($this->modelClass::findAll() as $basketItem) {
            $product = $basketItem->getProduct();
            $element = [
                'id' => $basketItem->getId(),
                'name' => $basketItem->getName(),
                'count' => $basketItem->getCount(),
                'price' => $basketItem->getPrice(),
            ];

            if ($product instanceof Product) {
                $element['imageUrl'] = ProductHelper::getImageUrl($product);
                $element['detailUrl'] = ProductHelper::getDetailUrl($product);
                $element['article'] = $product->article;
            }


            $data[] = $element;
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
