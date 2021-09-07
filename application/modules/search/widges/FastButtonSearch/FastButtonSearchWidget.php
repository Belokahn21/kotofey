<?php

namespace app\modules\search\widges\FastButtonSearch;


use app\modules\search\models\entity\SearchQuery;
use yii\base\Widget;
use yii\caching\DbDependency;
use yii\db\Expression;

class FastButtonSearchWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        $models = \Yii::$app->cache->getOrSet('fast-button-search', function () {
            return SearchQuery::find()->where(['>', 'count_find', 0])->limit(10)->orderBy(['rand()' => SORT_DESC])->all();
        }, 3600 * 60 * 24, new DbDependency([
            'sql' => 'select count(`id`) from `search_query`'
        ]));

        return $this->render($this->view, [
            'models' => $models
        ]);
    }
}