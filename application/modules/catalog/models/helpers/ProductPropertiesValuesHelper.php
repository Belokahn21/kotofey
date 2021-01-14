<?php

namespace app\modules\catalog\models\helpers;


use app\modules\catalog\models\entity\Properties;
use app\modules\catalog\models\entity\PropertiesProductValues;
use app\modules\catalog\models\entity\PropertiesVariants;
use app\modules\site\models\helpers\ImageHelper;
use app\modules\site\models\tools\Debug;
use app\models\tool\System;
use app\modules\catalog\models\entity\SaveInformersValues;
use app\modules\catalog\models\entity\SaveProductPropertiesValues;
use app\modules\media\models\entity\Media;

class ProductPropertiesValuesHelper
{
    public static function getImageUrl(PropertiesVariants $model, $options = [])
    {
        if ($media = $model->media) {
            if ($media->location == Media::LOCATION_CDN) {

                if ($options) {
                    return \Yii::$app->CDN->resizeImage($model->media->cdnData['public_id'], $options);
                }

                return $media->cdnData['secure_url'];
            }
        }
        return ImageHelper::notFoundImage();
    }

    public static function getFinalValue(PropertiesProductValues $variant)
    {
        return $variant->property->type != 1 ? $variant->value : PropertiesVariants::findOne(['property_id' => $variant->property_id, 'id' => $variant->value])->name;
    }

    public static function savePropertyValue($product_id, $property_id, $value)
    {
        // save weight
        $obj = new SaveProductPropertiesValues();
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