<?php


namespace app\modules\delivery\models\service\delivery\api;


use app\modules\delivery\models\service\delivery\tariffs\TariffDataInterface;

interface DeliveryApi
{
    public function getNormalAddress($address);

    public function getPriceInfo(TariffDataInterface $tariff_data);

    public function sendRequest(string $url, array $data = [], array $headers = []);
}