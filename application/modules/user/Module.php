<?php

namespace app\modules\user;

/**
 * user module definition class
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\user\controllers';
    public $avatarPath = "/upload/avatar/";

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
