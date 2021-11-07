<?php

namespace app\modules\marketplace\models\entity;

use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\catalog\models\helpers\ProductPropertiesValuesHelper;
use app\modules\catalog\models\helpers\PropertiesHelper;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class OzonProduct extends Model
{
    public $name;
    public $offer_id;
    public $old_price;
    public $price;
    public $vat;
    public $weight;
    public $weight_unit;
    public $width;
    public $barcode;
    public $category_id;
    public $color_image;
    public $depth;
    public $dimension_unit;
    public $height;
    public $images;
    public $primary_image;

    public function loadAttrs(Product $model)
    {
        $this->setAttributes($model);

//        $this->barcode = ArrayHelper::getValue($model, 'barcode');
//        $this->color_image = ArrayHelper::getValue($model, 'color_image');
//        $this->depth = ArrayHelper::getValue($model, 'depth');
//        $this->images = ArrayHelper::getValue($model, 'images');
        $this->name = ArrayHelper::getValue($model, 'name');
        $this->category_id = ArrayHelper::getValue($model, 'category_id');

        $this->offer_id = ArrayHelper::getValue($model, 'article');
//        $this->price = ArrayHelper::getValue($model, 'price');
//        $this->old_price = ArrayHelper::getValue($model, 'old_price');
        $this->vat = ArrayHelper::getValue($model, 'vat');

        $this->weight_unit = 'kg';
        $this->dimension_unit = 'cm';

        $this->weight = ArrayHelper::getValue(PropertiesHelper::extractPropertyById($model, PropertiesHelper::PROPERTY_WEIGHT), 'value');
        $this->height = ArrayHelper::getValue(PropertiesHelper::extractPropertyById($model, PropertiesHelper::PROPERTY_HEIGHT), 'value');
        $this->width = ArrayHelper::getValue(PropertiesHelper::extractPropertyById($model, PropertiesHelper::PROPERTY_WIDTH), 'value');
        $this->primary_image = ProductHelper::getImageUrl($model, true);
    }

    public function rules()
    {
        return [
            [[], 'required'],
            [[], 'string'],
            [[], 'integer'],
        ];
    }
}