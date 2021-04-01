<?php


namespace app\modules\payment\models\services\equiring\banks;


use app\modules\order\models\entity\Order;
use app\modules\order\models\helpers\OrderHelper;
use app\modules\payment\models\services\equiring\auth\SberbankAuth;
use app\modules\site\models\tools\Curl;
use app\modules\site\models\tools\Debug;
use yii\helpers\Json;

class Sberbank implements EquiringBank
{
    private $auth;

    public function __construct(SberbankAuth $auth)
    {
        $this->auth = $auth;
    }

    public function getAuthParams(array &$params)
    {
        $this->auth->getAuthParams($params);
    }
}