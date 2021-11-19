<?php

namespace app\modules\marketplace\models\api;

use app\modules\marketplace\models\entity\OzonProduct;
use app\modules\site\models\tools\Debug;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\httpclient\Client;

class OzonApi
{
    private $headers = [];
    private $client;

    public function __construct()
    {
        $this->headers = [
            'Client-Id' => 217561,
            'Api-Key' => '58b731ca-9643-4977-affc-f964c70df59f',
            'Content-type' => 'application/json',
        ];

        $this->client = new Client([
            'baseUrl' => 'https://api-seller.ozon.ru',
        ]);
    }

    public function createProduct(OzonProduct $data)
    {
        $response = $this->postRequest('/v2/product/import', ArrayHelper::toArray($data));
        return ArrayHelper::getValue($this->getData($response), 'task_id');
    }

    public function getProducts()
    {
        $response = $this->postRequest('/v1/product/list', []);
        return ArrayHelper::getValue($this->getData($response), 'items');
    }

    public function getProduct($offer_id = null, $product_id = null, $sku = null)
    {
        $params = [];

        if ($offer_id !== null) $params['offer_id'] = strval($offer_id);
        if ($product_id !== null) $params['product_id'] = $product_id;
        if ($sku !== null) $params['sku'] = $sku;

        if (!$params) return false;

        $response = $this->postRequest('/v2/product/info', $params);
        return $this->getData($response);
    }

    public function ozonProductList()
    {
        $response = $this->postRequest('/v2/product/info/stocks', []);
        return ArrayHelper::getValue($this->getData($response), 'items');
    }

    public function listCategoryCharacteristic()
    {
        $response = $this->postRequest('/v3/category/attribute', [
            'attribute_type' => "ALL",
            'category_id' => [0],
            'language' => "RU",
        ]);

        Debug::p($response);
        exit();

        return ArrayHelper::getValue($this->getData($response), 'result');
    }

    public function updateCount(int $amount, int $article)
    {
        $response = $this->postRequest('/v2/products/stocks', [
            'offer_id' => $article,
            'stock' => $amount,
            'warehouse_id' => 22215334034000,
        ]);


        Debug::p($response);
        exit();
        return ArrayHelper::getValue($this->getData($response), 'result');
    }

    private function postRequest(string $action, array $data)
    {
        $json_data = !$data ? $data : Json::encode($data);
        return $this->client->post($action, $json_data, $this->headers)->send();
    }


    private function getReq(array $data)
    {
    }

    private function getData($response)
    {
        return ArrayHelper::getValue($response, 'data.result');
    }
}