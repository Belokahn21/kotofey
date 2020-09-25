<?php

namespace app\modules\catalog\models\helpers;


use app\models\tool\Debug;
use app\modules\catalog\models\entity\ProductPropertiesValues;

class ProductPropertiesValuesHelper
{
    public static function savePropertyValue($product_id, $property_id, $value)
    {
        // save weight
        $obj = new ProductPropertiesValues();
        $obj->property_id = $property_id;
        $obj->product_id = $product_id;
        $obj->value = $value;

        if (!$obj->validate()) {
            Debug::p('Ошибка валидации значения');
            Debug::p($obj->getErrors());
            return false;
        }

        if (!$obj->save()) {
            Debug::p('Ошибка сохранения значения свойства');
            Debug::p($obj->getErrors());

            return false;
        }

        return true;
    }
}