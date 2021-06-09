<?php

namespace app\modules\delivery\models\service\delivery\tariffs\services;

use app\modules\delivery\models\service\delivery\tariffs\RuPostTariffData;

class ProvideTariff
{
    /**
     * @param $data
     * @return RuPostTariffData
     * @throws \Exception
     */
    public function make($data): RuPostTariffData
    {
        switch ($data['service']) {
            case "ru_post":
                return new RuPostTariffData($data);
            default:
                throw new \Exception('Не указан сервис доставки для расчёта стоимости отправления.');
        }
    }
}