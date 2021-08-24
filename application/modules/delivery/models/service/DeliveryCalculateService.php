<?php

namespace app\modules\delivery\models\service;

use app\modules\delivery\models\service\delivery\api\DeliveryApiOld;
use app\modules\delivery\models\service\delivery\api\DpdApi;
use app\modules\delivery\models\service\delivery\api\RussianPostApi;
use app\modules\delivery\models\service\delivery\tariffs\TariffDataInterface;
use app\modules\delivery\models\service\tracking\api\CdekApi;


/**
 * @property  DeliveryApiOld $api
 */
class DeliveryCalculateService
{
    const SERVICE_CDEK = 'cdek';
    const SERVICE_RU_POST = 'ru_post';
    const SERVICE_DPD = 'dpd';

    private $api;

    public function __construct(string $service)
    {
        $this->getApi($service);
    }

    public function getApi($service)
    {
        switch ($service) {
            case  self::SERVICE_CDEK:
                $this->api = new CdekApi();
                break;
            case self::SERVICE_DPD:
                $this->api = new DpdApi();
                break;
            case self::SERVICE_RU_POST:
                $this->api = new RussianPostApi();
                break;
            default:
                throw new \Exception('Не поддерживаемый сервис доставки.');
        }
    }

    public function getNormalAddress($address)
    {
        return $this->api->getNormalAddress($address);
    }

    public function getNormalPhone($phone)
    {
        return $this->api->getNormalPhone($phone);
    }

    public function getPriceInfo(TariffDataInterface $tariff_data)
    {
        $total = false;

        try {
            $total = $this->api->getPriceInfo($tariff_data);
        } catch (\Exception $exception) {
            echo "При вычислении стоимости доставки произошла ошибка: " . $exception->getMessage() . PHP_EOL . $exception->getFile() . PHP_EOL . $exception->getLine();
        }

        return $total;
    }
}