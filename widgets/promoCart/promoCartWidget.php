<?php

namespace app\widgets\promoCart;

use yii\base\Widget;

class promoCartWidget extends Widget
{
    public function run()
    {
        return $this->render('promo');
    }

    public function init()
    {
        parent::init();
    }
}