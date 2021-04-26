<?php


namespace app\modules\payment\models\services\acquiring\auth;


interface SberbankAuth
{
    public function getAuthParams(&$params);
}