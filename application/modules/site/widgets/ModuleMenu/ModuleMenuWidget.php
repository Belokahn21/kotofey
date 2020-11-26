<?php

namespace app\modules\site\widgets\ModuleMenu;

use yii\bootstrap\Widget;

class ModuleMenuWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        return $this->render($this->view);
    }
}