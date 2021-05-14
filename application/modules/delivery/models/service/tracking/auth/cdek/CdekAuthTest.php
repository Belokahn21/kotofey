<?php


namespace app\modules\delivery\models\service\tracking\auth\cdek;


use app\modules\site\models\tools\Curl;

class CdekAuthTest extends ACdekAuthApi
{
    protected $_url = 'https://api.edu.cdek.ru/v2/oauth/token?parameters';

    public function __construct(string $login, string $password)
    {
        parent::__construct($login, $password);
    }
}