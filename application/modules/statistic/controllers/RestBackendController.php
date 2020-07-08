<?php

namespace app\modules\statistic\controllers;

use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\order\models\entity\Order;
use yii\helpers\Json;
use yii\web\Controller;
use app\models\tool\Price;
use app\modules\order\models\helpers\OrderHelper;

class RestBackendController extends Controller
{
    protected function verbs()
    {
        return [
            'get' => ['GET']
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
    public function actionGet()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $products = Product::find();
        $elements = [
            [
                'icon'=>'fa-clipboard',
                'data'=>[
                    [
                        'title'=>'Заказов',
                        'value'=>Order::find()->count(),
                    ],
                    [
                        'title'=>'Оборот',
                        'value'=> Price::format(OrderHelper::income())
                    ],
                    [
                        'title'=>'Доход',
                        'value'=>Price::format(OrderHelper::marginality()),
                    ]
                ]
            ],
            [
                'icon'=>'fa-clipboard',
                'data'=>[
                    [
                        'title'=>'Товаров',
                        'value'=>$products->where(['>','count',0])->count(),
                    ],
                    [
                        'title'=>'Закуп',
                        'value'=> Price::format(ProductHelper::purchaseVirtual($products->where(['>','count',0])->all()))
                    ],
                    [
                        'title'=>'Доход',
                        'value'=> Price::format(ProductHelper::profitVirtual($products->where(['>','count',0])->all()))
                    ],
                ]
            ],
        ];
        return Json::encode($elements);
    }
}
