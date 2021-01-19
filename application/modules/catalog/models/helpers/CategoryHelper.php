<?php

namespace app\modules\catalog\models\helpers;

use app\modules\catalog\models\entity\ProductCategory;

class CategoryHelper
{
    public static function getDetailUrl(ProductCategory $model)
    {
        return "/catalog/" . $model->slug . "/";
    }
}