<?php

namespace app\modules\search;

use yii\helpers\Url;

class Module extends \app\modules\site\MainModule
{
    public $controllerNamespace = 'app\modules\search\controllers';
    private $name = 'Поиск';

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            ['name' => 'История поиска', 'url' => Url::to(['/admin/search/search-history-backend/index'])],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
