<?php

namespace app\modules\basket;

/**
 * basket module definition class
 */
class Module extends \app\modules\site\MainModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\basket\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
