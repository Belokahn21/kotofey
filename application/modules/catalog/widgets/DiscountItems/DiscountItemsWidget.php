<?php

namespace app\modules\catalog\widgets\DiscountItems;


use app\models\tool\Debug;
use app\modules\catalog\models\entity\InformersValues;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\ProductPropertiesValues;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class DiscountItemsWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        $formatArray = array();

        $models = Product::find()->where(['>', 'discount_price', 0])->andWhere(['status_id' => Product::STATUS_ACTIVE])->all();
        $arProductIds = ArrayHelper::getColumn($models, 'id');
        $productPropertiesValues = ProductPropertiesValues::find()->where(['product_id' => $arProductIds, 'property_id' => [1, 11]])->select(['value'])->groupBy('value')->all();
        $values = ArrayHelper::getColumn($productPropertiesValues, 'value');
        $informersValues = InformersValues::find()->where(['id' => $values])->all();


        $tmpId = null;
        foreach ($informersValues as $value) {
            if ($value->informer_id == 1) {

                $tmpId = $value->id;

                $formatArray['brands'][$tmpId][] = $value;
//                $formatArray['brands'][$tmpId][] = rand();
            } else {
                $formatArray['actions'][$tmpId] = $value;
//                $formatArray['actions'][$tmpId][] = rand();
            }
        }

//        Debug::p($formatArray);
//        exit();

        return $this->render($this->view, [
            'models' => $models,
            'formatArray' => $formatArray
        ]);
    }
}