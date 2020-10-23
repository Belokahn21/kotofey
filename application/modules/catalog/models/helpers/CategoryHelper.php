<?php

namespace app\modules\catalog\models\helpers;

use app\modules\catalog\models\entity\Category;

class CategoryHelper
{
    public static function getDetailUrl(Category $model)
    {
        return "/catalog/" . $model->slug . "/";
    }
}