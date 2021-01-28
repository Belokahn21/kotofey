<?php

namespace app\modules\catalog\models\helpers;

use app\modules\catalog\models\entity\ProductCategory;

class CategoryHelper
{
    public static function getDetailUrl(ProductCategory $model)
    {
        return "/catalog/" . $model->slug . "/";
    }

    public static function getImageUrl(ProductCategory $model)
    {
        return "/upload/" . $model->image;
    }
}