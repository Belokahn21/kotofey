<?php

namespace app\widgets\catalog_filter;


use app\models\entity\InformersValues;
use app\models\entity\ProductPropertiesValues;
use app\models\forms\CatalogFilter;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class CatalogFilterWidget extends Widget
{
    public $template = 'default';

    public function run()
    {
        $filterModel = new CatalogFilter();
        if (\Yii::$app->request->isPjax) {
            $filterModel->load(\Yii::$app->request->post());
        }


        $listCompany = InformersValues::find()->where(['informer_id' => '1'])->all();
        $listType = InformersValues::find()->where(['informer_id' => '2']);
        $listType = $listType->all();

        return $this->render($this->template, [
            'filterModel' => $filterModel,
            'listType' => $listType,
            'listCompany' => $listCompany,
        ]);
    }
}