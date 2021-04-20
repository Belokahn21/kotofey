<?php

namespace app\modules\media;

use app\modules\site\MainModule;
use yii\helpers\Url;

/**
 * media module definition class
 */
class Module extends MainModule
{
    public $controllerNamespace = 'app\modules\media\controllers';
    public $name = 'Медиа';

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Медиа', 'url' => Url::to(['/admin/media/media-backend/index'])],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
