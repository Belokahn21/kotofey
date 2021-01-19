<?php


namespace app\modules\catalog\widgets\Recomended;


use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\Properties;
use app\modules\catalog\models\entity\TypeProductProperties;
use yii\base\Widget;

class RecomendedWidget extends Widget
{
    public $view = 'default';
    public $property_id;
    public $product;

    public function run()
    {
        if (empty($this->property_id)) return false;
        $property = Properties::findOne($this->property_id);

        if (!$property instanceof Properties or $property->type != TypeProductProperties::TYPE_CATALOG) return false;

        $property_id = $this->property_id;

        $models = \Yii::$app->cache->getOrSet('recomended:' . $this->product->id, function () use ($property_id) {
            return Product::find()->joinWith('propsValues')->where(['properties_product_values.property_id' => $property_id])->all();
        });

        return $this->render($this->view, [
            'models' => $models
        ]);
    }
}