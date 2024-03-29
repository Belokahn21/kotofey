<?php

namespace app\modules\news;


use app\modules\site\MainModule;
use yii\helpers\Url;

class Module extends MainModule
{
    public $controllerNamespace = 'app\modules\news\controllers';
    private $name = 'Новости';

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Новости', 'url' => Url::to(['/admin/news/news-backend/index'])],
            ['name' => 'Рубрики', 'url' => Url::to(['/admin/news/news-category-backend/index'])],
        ];
    }

    public function getName()
    {
        return $this->name;
    }
}
