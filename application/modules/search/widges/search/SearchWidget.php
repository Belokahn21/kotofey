<?php

namespace app\modules\search\widges\search;


use app\modules\search\models\entity\Search;
use app\modules\site\models\tools\Debug;
use yii\base\Widget;

class SearchWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        $model = new Search();
        $model->load(\Yii::$app->request->get());

        if (Debug::isPageSpeed()) return false;

        return $this->render($this->view, [
            'model' => $model
        ]);
    }
}