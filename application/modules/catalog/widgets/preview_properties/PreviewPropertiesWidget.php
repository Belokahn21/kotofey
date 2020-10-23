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
        $properties['Вес'] = 'Не указан';

        if ($weight = ProductPropertiesHelper::getProductWeight($this->product->id)) {
            $properties['Вес'] = $weight . "кг";
        }

        return $this->render($this->view, [
            'properties' => $properties
        ]);
    }
}