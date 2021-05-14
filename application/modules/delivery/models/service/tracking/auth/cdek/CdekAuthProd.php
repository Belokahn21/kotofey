<?php


namespace app\modules\delivery\models\service\tracking\auth\cdek;


class CdekAuthProd extends AbstractCdekAuthApi
{
    protected $_url = 'https://api.cdek.ru/v2/oauth/token?parameters';

    public function __construct(string $login, string $password)
    {
        parent::__construct($login, $password);
    }
}