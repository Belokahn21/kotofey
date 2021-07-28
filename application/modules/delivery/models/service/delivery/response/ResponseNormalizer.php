<?php

namespace app\modules\delivery\models\service\delivery\response;

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

        $card = new ResponseCard();
        $card->name = ArrayHelper::getValue($data, 'name');
        $card->total = ArrayHelper::getValue($data, 'total');
        $card->days = ArrayHelper::getValue($data, 'min-days');

        $list_cards[] = $card;
        return $list_cards;
    }

    public function normalizeRuPostResponse($data)
    {
        $list_cards = [];

        $card = new ResponseCard();
        $card->name = ArrayHelper::getValue($data, 'name');
        $card->total = Money::convertCopToRub(ArrayHelper::getValue($data, 'total-rate'));
        $card->max_days = ArrayHelper::getValue(ArrayHelper::getColumn($data, 'delivery-time'), 'max-days');
        $card->min_days = ArrayHelper::getValue(ArrayHelper::getColumn($data, 'delivery-time'), 'min-days');

        $list_cards[] = $card;
        return $list_cards;
    }
}