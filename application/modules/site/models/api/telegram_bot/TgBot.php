<?php

namespace app\modules\site\models\api\telegram_bot;

use app\modules\site\models\tools\Debug;
use yii\helpers\Json;

class TgBot
{
    private $tg_token;

    const TG_URL = 'https://api.telegram.org';
    const ACTION_SEND_MESSAGE = 'sendMessage';

    public function __construct()
    {
        $this->tg_token = $_ENV['TG_TOKEN'];
    }

    public function sendMessage(string $message, string $target, array $other_params = array())
    {
        return $this->get(self::ACTION_SEND_MESSAGE, array_merge([
            'chat_id' => $target,
            'text' => $message,
        ], $other_params));
    }

    public function get(string $method, array $params = array())
    {
        if ($curl = curl_init()) {
            $url = sprintf('%s/bot%s/%s', self::TG_URL, $this->tg_token, $method);

            if ($params) $url = $url . '?' . http_build_query($params);

            Debug::p($url);

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            $out = curl_exec($curl);
            curl_close($curl);

            $_response = Json::decode($out);

            return $_response;
        }
        return false;
    }

    public function post(string $method, array $params = array())
    {
        if ($curl = curl_init()) {
            curl_setopt($curl, CURLOPT_URL, sprintf('%s/bot%s/%s', self::TG_URL, $this->tg_token, $method));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            if ($params) curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
            $out = curl_exec($curl);
            curl_close($curl);

            $_response = Json::decode($out);

            return $_response;
        }
        return false;
    }
}