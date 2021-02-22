<?php

namespace app\modules\site\widgets\PageUp;


use yii\base\Widget;

class PageUpWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        return $this->render($this->view);
    }
}