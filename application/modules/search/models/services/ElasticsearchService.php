<?php

namespace app\modules\search\models\services;

use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\virtual\ProductElastic;

class ElasticsearchService
{
    public $count_all_success;
    public $count_all_products;

    public function reIndex()
    {
        ProductElastic::deleteIndex();
        ProductElastic::createIndex();

        $models = Product::find()->all();

        $this->count_all_success = 0;
        $this->count_all_products = count($models);

        foreach ($models as $model) {
            $el = new ProductElastic();
            $el->fillAttributes($model);
            $status = $el->insert();
            if ($status) $this->count_all_success++;
        }
    }
}