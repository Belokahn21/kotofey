<?php

namespace app\modules\catalog\widgets\preview_properties;


use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\helpers\ProductPropertiesHelper;
use yii\base\Widget;

class PreviewPropertiesWidget extends Widget
{
    public $view = 'default';
    public $product;

    public function run()
    {
        if (!$this->product instanceof Product) {
            return false;
        }

        $properties = array();
        $properties['Артикул'] = $this->product->article;
        $properties['Вес'] = ProductPropertiesHelper::getProductWeight($this->product->id) ? ProductPropertiesHelper::getProductWeight($this->product->id) . "кг" : 'Не указан';


        return $this->render($this->view, [
            'properties' => $properties
        ]);
    }
}