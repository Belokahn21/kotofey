<?php

namespace app\widgets\notification;


use yii\base\Widget;

class NotifyWidget extends Widget
{
    const COOKIE_NOTIFY_KEY = 'notify';
    const COOKIE_NOTIFY_VALUE = 'Y';
    public $template = 'notify';

    public function run()
    {
        $cookies = \Yii::$app->request->cookies;
        $cookie = $cookies->getValue(self::COOKIE_NOTIFY_KEY);
        if ($cookie == self::COOKIE_NOTIFY_VALUE) {
            return false;
        }
        return $this->render($this->template);
    }
}