<?php

namespace app\modules\search\widges\FastButtonSearch;


use app\modules\search\models\entity\SearchQuery;
use yii\base\Widget;
use yii\db\Expression;

class FastButtonSearchWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        $models = SearchQuery::find()->where(['>', 'count_find', 0])->limit(10)->orderBy(['rand()' => SORT_DESC])->all();

        return $this->render($this->view, [
            'models' => $models
        ]);
    }
}