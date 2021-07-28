<?php

namespace app\modules\delivery\models\service\delivery\response;

use app\modules\site\models\tools\Debug;
use app\modules\site\models\tools\Money;
use yii\helpers\ArrayHelper;

class ResponseNormalizer
{
    const SERVICE_CDEK = 'cdek';
    const SERVICE_RU_POST = 'ru_post';

    public function normalize(string $service_name, $data)
    {
        switch ($service_name) {
            case self::SERVICE_CDEK:
                return $this->normalizeCdekResponse($data);
            case self::SERVICE_RU_POST:
                return $this->normalizeRuPostResponse($data);
            default:
                return false;
        }
    }

    public function normalizeCdekResponse($data)
    {
        $list_cards = [];

//        Debug::printFile($data);

        if (is_object($data) && ArrayHelper::keyExists('tariff_codes', $data)) {
            foreach ($data->tariff_codes as $tariff_code) {
                $card = new ResponseCard();
                $card->name = ArrayHelper::getValue($data, 'tariff_name');
                $card->total = ArrayHelper::getValue($data, 'total_sum');
                $card->min_days = ArrayHelper::getValue($data, 'period_min');
                $card->max_days = ArrayHelper::getValue($data, 'period_max');

                $list_cards[] = $card;
            }
        } else {
            $card = new ResponseCard();
            $card->total = ArrayHelper::getValue($data, 'total_sum');
            $card->min_days = ArrayHelper::getValue($data, 'period_min');
            $card->max_days = ArrayHelper::getValue($data, 'period_max');

            $list_cards[] = $card;
        }

        return $list_cards;
    }

    public function normalizeRuPostResponse($data)
    {
        $list_cards = [];

//        Debug::printFile($data);

        $card = new ResponseCard();
        $card->name = ArrayHelper::getValue($data, 'name');
        $card->total = Money::convertCopToRub(ArrayHelper::getValue($data, 'total-rate'));
        $card->max_days = ArrayHelper::getValue(ArrayHelper::getValue($data, 'delivery-time'), 'max-days');

        $list_cards[] = $card;
        return $list_cards;
    }
}