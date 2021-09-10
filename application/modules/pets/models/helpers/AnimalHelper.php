<?php

namespace app\modules\pets\models\helpers;

use app\modules\media\models\entity\Media;
use app\modules\media\models\helpers\MediaHelper;
use app\modules\pets\models\entity\Animal;
use app\modules\site\models\tools\System;

class AnimalHelper
{
    public static function getImageUrl(Animal $model, $isFull = false, $options = [])
    {
        return MediaHelper::getImageUrl($model, $isFull, $options);
    }
}