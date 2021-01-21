<?php

namespace app\modules\catalog\widgets\CatalogFilter;


use app\modules\catalog\models\entity\PropertiesVariants;
use yii\base\Widget;

class CatalogFilterWidget extends Widget
{
    public $view = 'default';
    public $product_id;

    public function run()
    {
        $models = PropertiesVariants::find()->all();




        return $this->render($this->view, [
            'models' => $models
        ]);
    }
}