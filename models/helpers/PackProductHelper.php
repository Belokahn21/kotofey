<?php

namespace app\models\helpers;


use app\models\entity\Product;

class PackProductHelper
{
    const UNIQ_ID_ECO_PACK = 'e22qle';
    const UNIQ_ID_SIMPLE_PACK = 's893';

    /**
     * @return array
     */
    public static function listPack()
    {
        $eco_pack = new Product();
        $eco_pack->name = "Эко-упакова";
        $eco_pack->price = 70;
        $eco_pack->purchase = 50;
        $eco_pack->image = "eco.jpg";

        $simple_pack = new Product();
        $simple_pack->name = "Обычная упакова";
        $simple_pack->price = 0;
        $simple_pack->purchase = 0;
        $simple_pack->image = 'plastic.jpeg';


        return [
            self::UNIQ_ID_ECO_PACK => $eco_pack,
            self::UNIQ_ID_SIMPLE_PACK => $simple_pack,
        ];
    }

    public static function getDefaultProductId()
    {
        return self::UNIQ_ID_SIMPLE_PACK;
    }

    public static function findByPrimary($uniq_id)
    {
        return self::listPack()[$uniq_id];
    }
}