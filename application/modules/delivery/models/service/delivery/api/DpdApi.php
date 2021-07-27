<?php


namespace app\modules\delivery\models\service\delivery\api;


use app\modules\delivery\models\service\delivery\api\DeliveryApiOld;
use app\modules\delivery\models\service\delivery\tariffs\TariffDataInterface;

class DpdApi implements DeliveryApiOld
{

    public function getNormalAddress($address)
    {
        // TODO: Implement getNormalAddress() method.
    }

    public function getPriceInfo(TariffDataInterface $tariff_data)
    {
        // TODO: Implement getPriceInfo() method.
    }

    public function sendRequest(string $url, array $data = [], array $headers = [])
    {
        // TODO: Implement sendRequest() method.
    }
}