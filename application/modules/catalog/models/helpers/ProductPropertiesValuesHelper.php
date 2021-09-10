<?php

namespace app\modules\catalog\models\helpers;


use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\PropertiesProductValues;
use app\modules\catalog\models\entity\PropertiesVariants;
use app\modules\catalog\models\entity\TypeProductProperties;
use app\modules\media\models\helpers\MediaHelper;
use app\modules\site\models\helpers\ImageHelper;
use app\modules\site\models\tools\Debug;
use app\modules\media\models\entity\Media;
use yii\helpers\Url;

class ProductPropertiesValuesHelper
{
    public static function getImageUrl(PropertiesVariants $model, $isFull = false, $options = [])
    {
        return MediaHelper::getImageUrl($model->media, $isFull, $options);
    }

    public static function getBrandDetailUrl(PropertiesVariants $variant)
    {
        return Url::to(['/catalog/brand/view', 'id' => $variant->slug]);
    }

    public static function getFinalValue(PropertiesProductValues $variant)
    {
        $value = null;

        switch ($variant->property->type) {
            case TypeProductProperties::TYPE_TEXT:
                $value = $variant->value;
                break;
            case TypeProductProperties::TYPE_INFORMER:
                $value = PropertiesVariants::findOne(['property_id' => $variant->property_id, 'id' => $variant->value])->name;
                break;
            case TypeProductProperties::TYPE_CATALOG:
                $value = Product::findOne($variant->value)->name;
                break;
        }

        return $value;
    }

    public static function savePropertyValue($product_id, $property_id, $value)
    {
        if (PropertiesProductValues::findOne(['product_id' => $product_id, 'property_id' => $property_id, 'value' => $value])) return true;

        // save weight
        $obj = new PropertiesProductValues();
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

    public static function saveProductProperties(array $properties_data, int $product_id)
    {
        PropertiesProductValues::deleteAll(['product_id' => $product_id]);

        foreach ($properties_data as $propertyId => $value) {
            if (empty($value)) continue;

            //save multiple property
            if (is_array($value) && count($value) > 0) {
                foreach ($value as $select_variant) {
                    if (empty($select_variant)) continue;
                    $propertyValues = new PropertiesProductValues();
                    $propertyValues->product_id = $product_id;
                    $propertyValues->property_id = $propertyId;
                    $propertyValues->value = $select_variant;
                    if ($propertyValues->save() === false) {
                        return false;
                    }
                }
            } else {
                $propertyValues = new PropertiesProductValues();
                $propertyValues->product_id = $product_id;
                $propertyValues->property_id = $propertyId;
                $propertyValues->value = $value;
                if ($propertyValues->save() === false) {
                    return false;
                }
            }
        }
    }

    public static function removePropertyValue($product_id, $property_id)
    {
        return PropertiesProductValues::deleteAll(['product_id' => $product_id, 'property_id' => $property_id]);
    }
}