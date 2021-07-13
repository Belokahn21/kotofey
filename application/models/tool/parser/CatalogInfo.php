<?php

namespace app\models\tool\parser;


use app\modules\catalog\models\entity\Offers;

class CatalogInfo extends Offers
{
    public static function tableName()
    {
        return "product";
    }
}