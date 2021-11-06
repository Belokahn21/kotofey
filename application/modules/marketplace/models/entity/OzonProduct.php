<?php

namespace app\modules\marketplace\models\entity;

use app\modules\catalog\models\entity\Product;
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
        $this->offer_id = ArrayHelper::getValue($model, 'article');
        $this->price = ArrayHelper::getValue($model, 'price');
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