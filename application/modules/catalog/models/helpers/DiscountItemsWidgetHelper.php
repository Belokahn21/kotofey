<?php

namespace app\modules\catalog\models\helpers;

use app\models\tool\Debug;

class DiscountItemsWidgetHelper
{
    public static function getUrl(array $propertyActions, $key)
    {
        $stringUrlParams = '';

        if (array_key_exists($key, $propertyActions)) {
            foreach ($propertyActions[$key] as $actionInformerId => $action) {
                $stringUrlParams .= 'CatalogFilter[informer][' . $action['informer_id'] . '][]=' . $action['id'] . '&';
            }
        }

        if ($stringUrlParams) {
            return '/catalog/?' . substr($stringUrlParams, 0, -1);
        }

        return false;
    }
}