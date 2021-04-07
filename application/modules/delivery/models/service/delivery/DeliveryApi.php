<?php


namespace app\modules\delivery\models\service\delivery;


interface DeliveryApi
{
    public function getNormalAddress($address);

    public function getPriceInfo();

    public function sendRequest(string $url, array $data = [], array $headers = []);
}