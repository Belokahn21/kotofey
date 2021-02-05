<?php

namespace app\modules\content\widgets\informers_slider\model\helper;


use app\modules\catalog\models\entity\PropertiesVariants;
use app\modules\catalog\models\form\CatalogFilter;

class FilterBuildHelper
{
    public static function buildSearchQuery(PropertiesVariants $model)
    {
        $searchModel = new CatalogFilter();

        if (!$model->property) return false;

        $params['CatalogFilter'] = [
            'params' => [
                $model->property_id => $model->id
            ]
        ];

        /*
         * Array
(
    [CatalogFilter] => Array
        (
            [price_from] =>
            [price_to] =>
            [params] => Array
                (
                    [1] => Array
                        (
                            [0] => 1
                        )

                    [2] =>
                    [3] =>
                    [4] =>
                    [5] =>
                    [6] =>
                    [9] =>
                    [10] =>
                )

        )

)
         * */

        return http_build_query($params);
    }
}