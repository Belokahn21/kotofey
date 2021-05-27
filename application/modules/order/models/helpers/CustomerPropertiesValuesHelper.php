<?php

namespace app\modules\order\models\helpers;

use app\modules\site\models\tools\Debug;
use Yii;
use app\modules\order\models\entity\CustomerPropertiesValues;

class CustomerPropertiesValuesHelper
{
    public static function saveItems(int $customer_id)
    {
        $count = count(Yii::$app->request->post('CustomerPropertiesValues', []));

        $items = [new CustomerPropertiesValues()];

        for ($i = 1; $i < $count; $i++) {
            $items[] = new CustomerPropertiesValues();
        }

        CustomerPropertiesValues::deleteAll(['customer_id' => $customer_id]);

        if (CustomerPropertiesValues::loadMultiple($items, Yii::$app->request->post())) {

            foreach ($items as $item) {

//                if (OrderHelper::isEmptyItem($item)) continue;

                $item->customer_id = $customer_id;
                if (!$item->validate() || !$item->save()) {
                    Debug::p($item->getErrors());
                    return false;
                }
            }

        }

        return true;
    }
}