<?php

namespace app\modules\basket\widgets\MiniMobileCart;


use yii\base\Widget;

class MiniMobileCartWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        return $this->render($this->view);
    }
}