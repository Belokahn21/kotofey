<?php

namespace app\modules\promotion;

use yii\helpers\Url;

class Module extends \app\modules\site\MainModule
{
    public $controllerNamespace = 'app\modules\promotion\controllers';
    public $name = 'Акции';

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Акции', 'url' => Url::to(['/admin/promotion/promotion-backend/index'])],
        ];
    }
}
