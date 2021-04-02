<?php


namespace app\modules\delivery\models\service\delivery;


interface DeliveryApi
{
    public function getNormalAddress($address);
    public function getPriceInfo($address);
}