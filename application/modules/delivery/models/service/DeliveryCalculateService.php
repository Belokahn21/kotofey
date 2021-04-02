<?php

namespace app\modules\delivery\models\service;

use app\modules\delivery\models\service\delivery\CdekApi;
use app\modules\delivery\models\service\delivery\DeliveryApi;
use app\modules\delivery\models\service\delivery\DpdApi;
use app\modules\delivery\models\service\delivery\RussianPostApi;


/**
 * @property  DeliveryApi $api
 */
class DeliveryCalculateService
{
    private $api;

    public function __construct(string $service, string $address)
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

        return $this->getPriceInfo($address);
    }


    public function getPriceInfo($address)
    {
        $address = $this->api->getNormalAddress($address);


        $total = $this->api->getPriceInfo($address);

        return $total;
    }


}