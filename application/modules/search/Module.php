<?php

namespace app\modules\search;

use yii\helpers\Url;

class Module extends \app\modules\site\MainModule
{
    const SEARCH_ENGINE_SITE = 'site';
    const SEARCH_ENGINE_ELASTIC = 'elastic';

    public $controllerNamespace = 'app\modules\search\controllers';
    private $name = 'Поиск';

    public $search_engine;

    public function init()
    {
        parent::init();
    }

    public function menuIndex()
    {
        return [
            ['name' => 'Elasticsearch управление', 'url' => Url::to(['/admin/search/elasticsearch-backend/index'])],
            ['name' => 'История поиска', 'url' => Url::to(['/admin/search/search-history-backend/index'])],
        ];
    }

    public function getName()
    {
        return $this->name;
    }


    public function getParams()
    {
        return [
            'search_engine' => $this->getSearchEngine(),
        ];
    }

    public function getParamsLabel()
    {
        return [
            'search_engine' => 'Поисковое ядро',
        ];
    }

    public function getSearchEngine()
    {
        return [
            self::SEARCH_ENGINE_SITE => 'Обычный поиск',
            self::SEARCH_ENGINE_ELASTIC => 'Elasticsearch',
        ];
    }
}
