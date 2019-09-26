<?php

namespace app\widgets\catalog_filter;


use app\models\entity\InformersValues;
use app\models\forms\CatalogFilter;
use yii\base\Widget;

class CatalogFilterWidget extends Widget
{
    public $template = 'default';

    public function run()
    {
        $catalogFilter = new CatalogFilter();
        $listCompany = InformersValues::find()->where(['informer_id' => '1'])->all();
        $listType = InformersValues::find()->where(['informer_id' => '2'])->all();

        return $this->render($this->template, [
            'catalogFilter' => $catalogFilter,
            'listType' => $listType,
            'listCompany' => $listCompany,
        ]);
    }
}