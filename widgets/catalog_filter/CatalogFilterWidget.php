<?php

namespace app\widgets\catalog_filter;


use app\models\entity\InformersValues;
use app\models\entity\ProductPropertiesValues;
use app\models\forms\CatalogFilter;
use app\models\tool\Debug;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class CatalogFilterWidget extends Widget
{
    public $template = 'default';

    public function run()
    {
        $filterModel = new CatalogFilter();
        if (\Yii::$app->request->isGet) {
            $filterModel->load(\Yii::$app->request->get());
        }

        $listCompany = InformersValues::find()->where(['informer_id' => '1', 'active' => true])->all();
        $listType = InformersValues::find()->where(['informer_id' => '2', 'active' => true])->all();
        $listLines = InformersValues::find()->where(['informer_id' => '3', 'active' => true])->all();
        $listTaste = InformersValues::find()->where(['informer_id' => '4', 'active' => true])->all();

        return $this->render($this->template, [
            'filterModel' => $filterModel,
            'listType' => $listType,
            'listCompany' => $listCompany,
            'listLines' => $listLines,
            'listTaste' => $listTaste,
        ]);
    }
}