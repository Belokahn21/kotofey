<?php

namespace app\modules\todo;

/**
 * todo module definition class
 */
class Module extends \app\modules\site\MainModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\todo\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
