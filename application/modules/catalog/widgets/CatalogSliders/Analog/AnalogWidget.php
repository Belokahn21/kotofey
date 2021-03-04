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


        $property = Properties::findOne($this->property_id);
        $property_id = $this->property_id;


        if (!$property instanceof Properties or $property->type != TypeProductProperties::TYPE_CATALOG) return false;


        $models = \Yii::$app->cache->getOrSet('analog:' . $this->product->id, function () use ($property_id) {
            return Product::find()->joinWith('propsValues')->where(['properties_product_values.property_id' => $property_id])->all();
        });


        return RenderSliderWidget::widget([
            'models' => $models,
            'title' => 'Аналогичные товары'
        ]);
    }
}