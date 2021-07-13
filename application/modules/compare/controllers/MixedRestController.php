<?php

namespace app\modules\compare\controllers;


use app\modules\catalog\models\entity\Offers;
use app\modules\catalog\models\entity\Properties;
use app\modules\catalog\models\entity\PropertiesProductValues;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\compare\models\entity\Compare;
use yii\rest\Controller;

class MixedRestController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        $ids = Compare::getListId();
        $models = [];
        $avail_properties = [];


        foreach ($ids as $id) {
            $product = Offers::find()->where(['id' => $id])->select(['id', 'name'])->one();
            if (!$product) continue;

            $models[$id] = [
                'product' => $product,
                'properties' => $product->propsValues,
                'detail_link' => ProductHelper::getDetailUrl($product),
                'detail_image' => ProductHelper::getImageUrl($product),
            ];


            foreach ($product->propsValues as $property_value_row) {
                if ($property_value_row instanceof PropertiesProductValues && $property_value_row->property instanceof Properties) {
                    $avail_properties[$property_value_row->property->id]['property'] = $property_value_row->property;
                }
            }
        }


        return [
            'models' => $models,
            'avail_properties' => $avail_properties,
        ];
    }
}