<?php

namespace app\modules\search\widges\FastButtonSearch;


use yii\base\Widget;

class FastButtonSearchWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        return $this->render($this->view);
    }
}