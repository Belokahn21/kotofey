<?php

namespace app\modules\catalog\widgets\PreviewProperties;


use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\helpers\PropertiesHelper;
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
//        if ($this->product->count > 0) $properties['В наличии'] = $this->product->count . ' шт.';
        if ($this->product->status_id == Product::STATUS_ACTIVE) $properties['В наличии'] = '<i style="color: #00b000;" class="fas fa-check"></i>';

        if ($this->product->propsValues) {
            foreach ($this->product->propsValues as $property) {
                if ($property->property && $property->property->id == 2) {
                    $properties['Вес'] = $property->value . 'кг';
                }
            }
        }

        return $this->render($this->view, [
            'properties' => $properties
        ]);
    }
}