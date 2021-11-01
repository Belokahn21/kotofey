<?php

namespace app\modules\marketplace\models\services;

use app\modules\site\models\tools\Debug;
use yii\httpclient\Client;

class MarketplaceService
{
    public function getGoods()
    {
        $client = new Client([
            'baseUrl' => 'https://api-seller.ozon.ru/v1',
            ''
        ]);

        $client->createRequest()->setHeaders([
            'clientId' => 217561
        ]);

        $response = $client->post('/product/list', [
        ]);

        Debug::p($response);
    }
}