<?php

namespace app\modules\search\widges\LastQuery;

use app\modules\search\models\services\SearchHistory\SearchHistoryStorage;
use yii\base\Widget;

class LastQueryWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        $storage = new SearchHistoryStorage();
        $query = $storage->get();

        return $this->render($this->view, [
            'query' => $query
        ]);
    }
}