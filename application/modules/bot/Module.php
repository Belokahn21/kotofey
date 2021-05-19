<?php

namespace app\modules\bot;

/**
 * bot module definition class
 */
class Module extends \app\modules\site\MainModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\bot\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
