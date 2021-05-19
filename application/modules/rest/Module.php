<?php

namespace app\modules\rest;

/**
 * rest module definition class
 */
class Module extends \app\modules\site\MainModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\rest\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
