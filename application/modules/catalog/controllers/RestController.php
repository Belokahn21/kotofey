<?php

namespace app\modules\catalog\controllers;


use app\modules\catalog\models\entity\ProductCategory;
use app\modules\catalog\models\entity\PropertiesVariants;
use app\modules\catalog\models\helpers\OfferHelper;
use yii\helpers\Json;
use app\modules\catalog\models\entity\Offers;
use yii\rest\ActiveController;
use yii\rest\Controller;

class RestController extends ActiveController
{
    public $modelClass = 'app\modules\catalog\models\entity\Offers';
    public $searchModelClass = 'app\modules\catalog\models\search\OffersSearchForm';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['dataFilter'] = [
            'class' => \yii\data\ActiveDataFilter::class,
            'searchModel' => $this->searchModelClass,
        ];
        $actions['index']['prepareDataProvider'] = function ($action) {
            $model = new $this->searchModelClass();
            $model->load(\Yii::$app->request->queryParams);
            return $model->search(\Yii::$app->request->queryParams);
        };

        return $actions;
    }


//    public function actionGet()
//    {
//        $query = Product::find();
//        $query->asArray(true);
//        $data = \Yii::$app->request;
//        $products = null;
//
//        if ($name = $data->get('name')) {
//            foreach (explode(' ', $name) as $text_line) {
//                $query->andFilterWhere([
//                    'or',
//                    ['like', 'name', $text_line],
//                    ['like', 'feed', $text_line]
//                ]);
//            }
//        }
//        $products = $query->all();
//
//        foreach ($products as &$product) {
//            $product['href'] = ProductHelper::getDetailUrl(Product::findOne($product['id']));
//        }
//        return Json::encode($products);
//    }
//
//    public function actionRun()
//    {
//        $out = [];
//        $products = Product::find()->all();
//
//        foreach ($products as $product) {
//            $out[] = [
//                'name' => $product->name,
//                'category_id' => $product->category_id,
//                'description' => $product->description,
//                'price' => $product->price,
//                'discount_price' => $product->discount_price,
//                'purchase' => $product->purchase,
//                'count' => $product->count,
//                'code' => $product->code,
//                'barcode' => $product->barcode,
//                'vitrine' => $product->vitrine,
//                'feed' => $product->feed,
//                'image' => @$product->media->cdnData,
//            ];
//        }
//
//        return Json::encode($out);
//    }
//
//    public function actionProps()
//    {
//        return Json::encode(PropertiesVariants::find()->all());
//    }
//
//    public function actionCategory()
//    {
//        return Json::encode(ProductCategory::find()->orderBy(['parent' => SORT_ASC])->all());
//    }
}