<?php


namespace app\modules\payment\models\services\equiring\banks;


use app\modules\payment\models\services\equiring\auth\SberbankAuth;

class Open implements EquiringBank
{

    public function __construct(SberbankAuth $auth)
    {
    }

    public function getAuthParams(array &$params)
    {
        // TODO: Implement getAuthParams() method.
    }
}