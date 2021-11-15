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

//        $this->images = ArrayHelper::getValue($model, 'images');
        $this->name = ArrayHelper::getValue($model, 'name');
        $this->category_id = ArrayHelper::getValue($model, 'ozon_id');

        $this->offer_id = ArrayHelper::getValue($model, 'article');
//        $this->price = ArrayHelper::getValue($model, 'price');
//        $this->old_price = ArrayHelper::getValue($model, 'old_price');

        $this->vat = '0';
        $this->weight_unit = 'kg';
        $this->dimension_unit = 'cm';

        $this->depth = (int)ArrayHelper::getValue(PropertiesHelper::extractPropertyById($model, PropertiesHelper::PROPERTY_LENGTH), 'value');
        $this->weight = (int)ArrayHelper::getValue(PropertiesHelper::extractPropertyById($model, PropertiesHelper::PROPERTY_WEIGHT), 'value');
        $this->height = (int)ArrayHelper::getValue(PropertiesHelper::extractPropertyById($model, PropertiesHelper::PROPERTY_HEIGHT), 'value');
        $this->width = (int)ArrayHelper::getValue(PropertiesHelper::extractPropertyById($model, PropertiesHelper::PROPERTY_WIDTH), 'value');
        $this->primary_image = ProductHelper::getImageUrl($model, true);
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'vat', 'offer_id'], 'string'],
            [['price', 'old_price', 'category_id', 'height', 'weight', 'width', 'width', 'depth'], 'integer'],
        ];
    }
}