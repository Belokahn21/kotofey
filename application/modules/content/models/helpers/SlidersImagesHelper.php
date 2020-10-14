<?php

namespace app\modules\content\models\helpers;


use app\modules\content\models\entity\SlidersImages;

class SlidersImagesHelper
{
    public static function getImageUrl(SlidersImages $model)
    {
        return '/upload/' . $model->image;
    }
}