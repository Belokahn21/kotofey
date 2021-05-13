<?php


namespace app\modules\delivery\models\service\tracking\auth;


use app\modules\site\models\tools\Curl;

class CdekAuth
{
    public function __construct(string $login, string $password)
    {
        $c = new Curl();

        $c->post();
    }
}