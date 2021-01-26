<?php

namespace app\modules\catalog\models\helpers;


use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\Properties;
use app\modules\catalog\models\entity\PropertiesProductValues;
use app\modules\catalog\models\entity\PropertiesVariants;
use app\modules\catalog\models\entity\TypeProductProperties;
use app\modules\site\models\helpers\ImageHelper;
use app\modules\site\models\tools\Debug;
use app\modules\site\models\tools\System;
use app\modules\catalog\models\entity\SaveInformersValues;
use app\modules\catalog\models\entity\SaveProductPropertiesValues;
use app\modules\media\models\entity\Media;
use yii\helpers\Url;

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