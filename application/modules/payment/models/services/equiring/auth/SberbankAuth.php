<?php


namespace app\modules\payment\models\services\equiring\auth;


interface SberbankAuth
{
    public function getAuthParams(&$params);
}