<?php

namespace app\modules\catalog\widgets\CatalogFilter;

use app\modules\catalog\models\entity\PropertiesProductValues;
use app\modules\catalog\models\form\CatalogFilter;
use app\modules\site\models\tools\Debug;
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
            if (is_array($this->product_id)) $values->andFilterWhere(['in', 'properties_product_values.product_id', $this->product_id]);
            else $values->andFilterWhere(['properties_product_values.product_id' => $this->product_id]);
        }

        $values->joinWith('property pr');
        $values->andWhere(['pr.is_active' => true, 'pr.is_show_site' => true]);

        $values = $values->all();


        $filterModel->load(\Yii::$app->request->get());

        return $this->render($this->view, [
            'filterModel' => $filterModel,
            'values' => $values,
        ]);
    }
}