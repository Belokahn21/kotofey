<?php

namespace app\modules\basket\widgets\MiniMobileCart;


use yii\base\Widget;
use yii\helpers\Url;

class MiniMobileCartWidget extends Widget
{
    public $view = 'default';

    public function run()
    {
        if (Url::current() == '/checkout/') return false;

        return $this->render($this->view);
    }
}