<?php


namespace app\modules\cdek\models\helpers;


class CdekDeliveryHelper
{
    const DELIVERY_BOX = 'box';
    const DELIVERY_GROUP_BOX = 'groupbox';

    public static function getBoxSizes()
    {
        return [
            [
                'id' => self::DELIVERY_BOX,
                'name' => 'Коробка 60х40х30 (Корм до 12кг/наполнитель)',
                'width' => '60',
                'height' => '40',
                'length' => '30',
                'weight' => 20
            ],
            [
                'id' => self::DELIVERY_GROUP_BOX,
                'name' => 'Набор коробок 180х120х90 (Корма до 12кг/наполнители)',
                'width' => '100',
                'height' => '50',
                'length' => '50',
                'weight' => 50
            ],
        ];
    }

    public static function getBoxSize($key)
    {
        foreach (self::getBoxSizes() as $boxSize) {
            if ($boxSize['id'] == $key) {
                return $boxSize;
            }
        }

        return false;
    }
}