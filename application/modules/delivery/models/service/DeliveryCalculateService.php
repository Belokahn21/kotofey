<?php

namespace app\modules\delivery\models\service;

use app\modules\delivery\models\service\delivery\CdekApi;
use app\modules\delivery\models\service\delivery\DeliveryApi;
use app\modules\delivery\models\service\delivery\DpdApi;
use app\modules\delivery\models\service\delivery\RussianPostApi;
use app\modules\site\models\tools\Debug;


/**
 * @property  DeliveryApi $api
 */
class DeliveryCalculateService
{
    private $api;

    public function __construct(string $service, string $address)
    {
        $this->getApi($service);

        return $this->getPriceInfo($address);
    }

    public function getApi($service)
    {
        switch ($service) {
            case  'cdek':
                $this->api = new CdekApi();
                break;
            case 'dpd':
                $this->api = new DpdApi();
                break;
            case 'russian_post':
                $this->api = new RussianPostApi();
                break;
            default:
                throw new \Exception('Не поддерживаемый сервис доставки.');
        }
    }


    public function getPriceInfo($address)
    {
        $address = $this->api->getNormalAddress($address);
        $total = false;


        try {
            $total = $this->api->getPriceInfo($address);
        } catch (\Exception $exception) {
            echo "При вычислении стоимости доставки произошла ошибка";
        }

        return $total;
    }
}