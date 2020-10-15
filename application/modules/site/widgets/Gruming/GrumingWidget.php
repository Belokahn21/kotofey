<?php

namespace app\modules\site\widgets\Gruming;


use yii\bootstrap\Widget;

class GrumingWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        return $this->render($this->view, []);
    }
}