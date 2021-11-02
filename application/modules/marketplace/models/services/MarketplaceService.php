<?php

namespace app\modules\marketplace\models\services;

use app\modules\site\models\tools\Debug;
use yii\httpclient\Client;

class MarketplaceService
{
    public function getGoods()
    {
        $headers = [
            'Client-Id' => 217561,
            'Api-Key' => '58b731ca-9643-4977-affc-f964c70df59f',
        ];
        $client = new Client([
            'baseUrl' => 'https://api-seller.ozon.ru/v1',
        ]);


        $response = $client->post('/product/list', [
            'page' => 0
        ], $headers)->send();

        Debug::p($response->data);
    }
}