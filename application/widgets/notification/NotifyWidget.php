<?php

namespace app\widgets\notification;


use app\modules\site\models\tools\Debug;
use yii\base\Widget;

class NotifyWidget extends Widget
{
    const COOKIE_NOTIFY_KEY = 'show_site_message';
    const COOKIE_NOTIFY_VALUE = 'N';
    public $template = 'notify';
    public $message;

    public function run()
    {
        if (empty($this->message)) return false;

        if (isset($_COOKIE[self::COOKIE_NOTIFY_KEY]) && ($_COOKIE[self::COOKIE_NOTIFY_KEY] == self::COOKIE_NOTIFY_VALUE)) return false;

        return $this->render($this->template, [
            'message' => $this->message
        ]);
    }
}