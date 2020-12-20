<?php

namespace app\modules\catalog\controllers;


use app\modules\catalog\models\entity\Category;
use app\modules\catalog\models\entity\PropertiesProductValues;
use app\modules\catalog\models\entity\PropertiesVariants;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\search\models\entity\Search;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use app\models\forms\CatalogFilter;
use app\modules\catalog\models\entity\Product;
use yii\rest\Controller;

class RestController extends Controller
{

    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
            ],
        ];
    }

    protected function verbs()
    {
        return [
            'get' => ['GET'],
            'run' => ['GET'],
            'category' => ['GET'],
        ];
    }

    public function actionGet()
    {
        $query = Product::find();
        $query->asArray(true);
        $data = \Yii::$app->request;
        $products = null;

        if ($name = $data->get('name')) {
            foreach (explode(' ', $name) as $text_line) {
                $query->andFilterWhere([
                    'or',
                    ['like', 'name', $text_line],
                    ['like', 'feed', $text_line]
                ]);
            }
        }
        $products = $query->all();

        foreach ($products as &$product) {
            $product['href'] = ProductHelper::getDetailUrl(Product::findOne($product['id']));
        }
        return Json::encode($products);
    }

    public function actionRun()
    {
        $out = [];
        $products = Product::find()->all();

        foreach ($products as $product) {
            $out[] = [
                'name' => $product->name,
                'category_id' => $product->category_id,
                'description' => $product->description,
                'price' => $product->price,
                'discount_price' => $product->discount_price,
                'purchase' => $product->purchase,
                'count' => $product->count,
                'code' => $product->code,
                'barcode' => $product->barcode,
                'vitrine' => $product->vitrine,
                'feed' => $product->feed,
                'image' => @$product->media->cdnData,
            ];
        }

        return Json::encode($out);
    }

    public function actionProps()
    {
        return Json::encode(PropertiesVariants::find()->all());
    }

    public function actionCategory()
    {
        return Json::encode(Category::find()->orderBy(['parent' => SORT_ASC])->all());
    }
}