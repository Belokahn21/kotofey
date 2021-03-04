<?php


namespace app\modules\catalog\widgets\CatalogSliders\Analog;


use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\Properties;
use app\modules\catalog\models\entity\TypeProductProperties;
use app\modules\catalog\widgets\CatalogSliders\RenderSlider\RenderSliderWidget;
use yii\base\Widget;

class AnalogWidget extends Widget
{
    public $view = 'default';
    public $property_id;
    public $product;

    public function run()
    {

        if (empty($this->property_id)) return false;

        $listIdRelatedItems = [];
        foreach ($this->product->propsValues as $propsValue) {
            if ($propsValue->property_id == $this->property_id) $listIdRelatedItems[] = (int)$propsValue->value;
        }

        $models = Product::find()->where(['in', 'id', $listIdRelatedItems])->all();


        return RenderSliderWidget::widget([
            'models' => $models,
            'uniqKey' => $this->property_id . $this->product->id,
            'title' => 'Аналогичные товары'
        ]);
    }
}