<?php

namespace app\modules\compare\controllers;

use app\modules\catalog\models\entity\Product;
use app\modules\compare\models\entity\Compare;
use yii\web\Controller;

class CompareController extends Controller
{
    public function actionIndex()
    {
        $ids = Compare::getListId();
        $models = [];
        $avail_properties = [];


        foreach ($ids as $id) {
            $product = Product::findOne($id);
            if (!$product) continue;

            $models[$id] = [
                'product' => $product,
                'properties' => $product->propsValues
            ];


            foreach ($product->propsValues as $property_value_row) {
                $avail_properties[$property_value_row->property->id]['property'] = $property_value_row->property;
            }
        }


        return $this->render('index', [
            'models' => $models,
            'avail_properties' => $avail_properties,
        ]);
    }
}
