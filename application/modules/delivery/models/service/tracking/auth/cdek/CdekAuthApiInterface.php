<?php


namespace app\modules\delivery\models\service\tracking\auth\cdek;


interface CdekAuthApiInterface
{
    public function __construct(string $login, string $password);
}