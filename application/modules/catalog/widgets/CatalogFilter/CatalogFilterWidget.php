<?php

namespace app\modules\catalog\widgets\CatalogFilter;


use app\modules\catalog\models\entity\PropertiesProductValues;
use app\modules\catalog\models\entity\PropertiesVariants;
use yii\base\Widget;

class CatalogFilterWidget extends Widget
{
    public $view = 'default';
    public $product_id;

    public function run()
    {
        $models = PropertiesVariants::find()->all();
        $values = PropertiesProductValues::find();
        if ($this->product_id) {
            if (is_array($this->product_id)) $values->where(['in', 'product_id', $this->product_id])
                else $values->where(['product_id' => $this->product_id]);
        }

        $values = $values->all();


        return $this->render($this->view, [
            'models' => $models,
            'values' => $values,
        ]);
    }
}