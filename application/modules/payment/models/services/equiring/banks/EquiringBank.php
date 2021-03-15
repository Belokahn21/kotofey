<?php


namespace app\modules\payment\models\services\equiring\banks;


use app\modules\payment\models\services\equiring\SberbankAuth;

interface EquiringBank
{
    public function __construct(SberbankAuth $auth);
    public function getAuthParams(array &$params);
}