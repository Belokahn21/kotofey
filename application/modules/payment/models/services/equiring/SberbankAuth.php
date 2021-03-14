<?php


namespace app\modules\payment\models\services\equiring;


interface SberbankAuth
{
    public function getAuthParams(&$params);
}