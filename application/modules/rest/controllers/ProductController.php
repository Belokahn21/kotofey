<?php

namespace app\modules\rest\controllers;

use app\models\entity\Product;
use app\models\tool\Debug;
use yii\helpers\Json;
use yii\web\Controller;

class ProductController extends Controller
{
    const ERROR_CODE = 400;
    const SUCCESS_CODE = 200;

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionCreate()
    {
        $status = self::SUCCESS_CODE;
        $response = null;
        $tempImageName = null;
        $tempPathInfo = null;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $json = file_get_contents('php://input');
        $data = Json::decode($json);
        $product = Product::findOne(['code' => $data['article']]);

        if ($product) {
            $status = self::ERROR_CODE;
            $response = new \Exception('Данный товар уже существует');
        }

        if (!empty($data['imageUrl'])) {
            $tempPathInfo = pathinfo($data['imageUrl']);
            if ($tempPathInfo) {
                $tempImageName = substr(md5(rand()), 0, 10);
                copy($data['imageUrl'], \Yii::getAlias('@app/web/upload/' . $tempImageName . '.' . $tempPathInfo['extension']));
            }
        }


        $product = new Product(['scenario' => Product::SCENARIO_CREATE_EXT_PRODUCT]);
        $product->name = $data['name'];
        $product->category_id = $data['category_id'];
        $product->description = $data['description'];
        $product->base_price = $data['base_price'];
        $product->purchase = $data['purchase'];
        $product->price = $data['price'];
        $product->count = $data['count'];
        $product->code = $data['article'];
        $product->active = 1;
        $product->vitrine = 1;
        if ($product->validate()) {

            if ($tempImageName) {
                $product->image = $tempImageName . '.' . $tempPathInfo['extension'];
            }

            if ($product->save(false)) {
                $response = "Товар успешно добавлен";
            }
        } else {
            try {
                unlink(\Yii::getAlias('@app/web/upload/' . $tempImageName . '.' . $tempPathInfo['extension']));
            } catch (\Exception $exception) {
            }
            $status = self::ERROR_CODE;
            $response = Debug::modelErrors($product);
        }

        return Json::encode([
            'status' => $status,
            'resultText' => $response
        ]);
    }

    public function actionGet($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return Json::encode(Product::findOne($id));
    }
}
