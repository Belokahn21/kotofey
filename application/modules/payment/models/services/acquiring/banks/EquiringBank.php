<?php


namespace app\modules\payment\models\services\acquiring\banks;


use app\modules\payment\models\services\acquiring\auth\SberbankAuth;

interface EquiringBank
{
    public function __construct(SberbankAuth $auth);
    public function getAuthParams(array &$params);
}