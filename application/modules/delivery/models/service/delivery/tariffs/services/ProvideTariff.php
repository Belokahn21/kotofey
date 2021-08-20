<?php

namespace app\modules\delivery\models\service\delivery\tariffs\services;

use app\modules\delivery\models\service\delivery\tariffs\CdekTariffData;
use app\modules\delivery\models\service\delivery\tariffs\RuPostTariffData;
use app\modules\delivery\models\service\DeliveryCalculateService;

class ProvideTariff
{
    public function make($data)
    {
        switch ($data['service']) {
            case DeliveryCalculateService::SERVICE_CDEK:
                return new CdekTariffData($data);
            case DeliveryCalculateService::SERVICE_RU_POST:
                return new RuPostTariffData($data);
            default:
                throw new \Exception('Не указан сервис доставки для расчёта стоимости отправления.');
        }
    }
}