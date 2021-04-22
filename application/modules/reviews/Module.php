<?php

namespace app\modules\reviews;

use app\modules\site\MainModule;
use yii\helpers\Url;

class Module extends MainModule
{
    public $controllerNamespace = 'app\modules\reviews\controllers';
    public $name = "Отзывы к товарам";

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Списки отзывов', 'url' => Url::to(['/admin/reviews/reviews-backend/index'])],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
