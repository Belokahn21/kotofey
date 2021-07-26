<?php

namespace app\modules\delivery\models\service\delivery\tariffs\services;

use app\modules\delivery\models\service\delivery\tariffs\CdekTariffData;
use app\modules\delivery\models\service\delivery\tariffs\RuPostTariffData;

class ProvideTariff
{
    public function make($data)
    {
        switch ($data['service']) {
            case "cdek":
                return new CdekTariffData($data);
            case "ru_post":
                return new RuPostTariffData($data);
            default:
                throw new \Exception('Не указан сервис доставки для расчёта стоимости отправления.');
        }
    }
}