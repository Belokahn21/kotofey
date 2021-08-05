<?php

namespace app\modules\pets\models\helpers;

use app\modules\pets\models\entity\Animal;

class AnimalHelper
{
    public static function getImageUrl(Animal $model)
    {
        return '/upload/' . $model->icon;
    }
}