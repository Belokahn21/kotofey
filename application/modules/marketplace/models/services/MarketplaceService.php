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
            'baseUrl' => 'https://api-seller.ozon.ru',
        ]);


        $response = $client->post('/v1/product/list', [
            'page' => 1,
            'page_size' => 20,
        ], $headers)->send();

        Debug::p($response->data);
    }
}