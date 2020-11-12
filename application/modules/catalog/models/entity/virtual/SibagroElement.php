<?php

namespace app\modules\catalog\models\entity\virtual;


use yii\base\Model;

class SibagroElement extends Model
{
    public $name;
    public $price;
    public $code;
    public $imagePath;
    public $weight;

    public function rules()
    {
        return [
            [['name', 'price', 'code', 'imagePath', 'weight'], 'string']
        ];
    }
}