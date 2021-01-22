<?php

namespace app\modules\catalog\widgets\CatalogFilter;

use app\modules\catalog\models\entity\PropertiesProductValues;
use app\models\forms\CatalogFilter;
use yii\base\Widget;

class CatalogFilterWidget extends Widget
{
    public $view = 'default';
    public $product_id;

    public function run()
    {
        $filterModel = new CatalogFilter();
        $values = PropertiesProductValues::find();

        if ($this->product_id) {
            if (is_array($this->product_id)) $values->where(['in', 'product_id', $this->product_id]);
            else $values->where(['product_id' => $this->product_id]);
        }

        $values->joinWith('property p');
        $values->where(['p.is_active' => true, 'p.is_show_site' => true]);

        $values = $values->all();


        $filterModel->load(\Yii::$app->request->get());

        return $this->render($this->view, [
            'filterModel' => $filterModel,
            'values' => $values,
        ]);
    }
}