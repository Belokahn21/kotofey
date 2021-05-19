<?php

namespace app\modules\search;

/**
 * search module definition class
 */
class Module extends \app\modules\site\MainModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\search\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
