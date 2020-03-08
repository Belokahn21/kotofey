<?php

namespace app\modules\bot\models\service;


use app\models\tool\Debug;

class BotRequestService
{
    private $_request;

    const TYPE_CONFIRM = 'confirmation';
    const TYPE_MESSAGE_NEW = 'message_new';

    public function __construct($request)
    {
        if (!is_array($request)) {
            throw new \Exception('Переменная запроса должна быть объектом');
        }
        $this->_request = $request;
    }

    public function isConfirm()
    {
        return $this->_request['type'] === self::TYPE_CONFIRM;
    }

    public function isMessage()
    {
        return $this->_request['type'] === self::TYPE_MESSAGE_NEW;
    }
}