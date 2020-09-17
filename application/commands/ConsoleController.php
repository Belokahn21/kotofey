<?php

namespace app\commands;

use app\models\tool\Debug;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\ProductPropertiesValues;
use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionRun()
    {
        $products = Product::find()->where(['vendor_id' => 3])->orWhere(['like', 'name', 'royal canin'])->andWhere(['>', 'discount_price', 0])->select(['id', 'name'])->all();

        foreach ($products as $product) {
            $row = new ProductPropertiesValues();
            $row->product_id = $product->id;
            $row->property_id = 11;
            $row->value = '211';

            if ($row->validate()) {
                if ($row->save()) {
                    Debug::p("Успешно вставлено");
                }
            } else {
                Debug::p($row->getErrors());
            }
        }
    }

    public function actionClearCache()
    {
        \Yii::$app->cache->flush();
    }
}
