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


        foreach ($models as $model) {
            $brand = $this->getBrandProperty($model->id);
            $action = $this->getDiscountProperty($model->id);


            if ($brand) {
                $formatArray['brands'][$brand['id']] = $brand;
            }

            if ($action) {
                $formatArray['actions'][$brand['id']][$action['id']] = $action;
            }

        }

        return $this->render($this->view, [
            'models' => $models,
            'formatArray' => $formatArray
        ]);
    }

    public function getBrandProperty($product_id)
    {
        $ProductPropertiesValues = ProductPropertiesValues::find()->where(['product_id' => $product_id, 'property_id' => 1])->all();
        $InformerValues = InformersValues::find()->select(['informer_id', 'id', 'name'])->where(['id' => ArrayHelper::getColumn($ProductPropertiesValues, 'value')])->asArray(true)->one();
        return $InformerValues;
    }

    public function getDiscountProperty($product_id)
    {
        $ProductPropertiesValues = ProductPropertiesValues::find()->where(['product_id' => $product_id, 'property_id' => 11])->all();
        $InformerValues = InformersValues::find()->select(['informer_id', 'id', 'name'])->where(['id' => ArrayHelper::getColumn($ProductPropertiesValues, 'value')])->asArray(true)->one();
        return $InformerValues;
    }
}