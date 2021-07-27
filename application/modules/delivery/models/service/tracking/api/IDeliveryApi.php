<?php


namespace app\modules\delivery\models\service\tracking\api;


use app\modules\delivery\models\service\delivery\tariffs\TariffDataInterface;
use app\modules\delivery\models\service\tracking\auth\cdek\CdekAuthApiInterface;

/**
 * @property CdekAuthApiInterface $auth
 */
interface IDeliveryApi
{
    public function getOrderInfo(string $track_id);

    public function getNormalAddress($address);

    public function getPriceInfo(TariffDataInterface $tariff_data);

    public function sendRequest(string $url, array $data = [], array $headers = []);
}