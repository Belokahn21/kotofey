<?php

namespace app\modules\bot\models\methods;

use VK\Client\VKApiClient;

class Message
{
    public function send($message, $params)
    {
        $access_token = '9b20f6f75e3d6afce2cfa6b16024dad5fadfbdc83cf92e57c7897a3310b4a5f17b7e0ce4ccd708fec1674';
        $vk = new VKApiClient();
        $message_response = $vk->messages()->send($access_token, [
            'user_id' => $params['user_id'],
            'random_id' => rand(1, 999999),
            'peer_id' => $params['user_id'],
            'message' => $message,
        ]);
    }
}