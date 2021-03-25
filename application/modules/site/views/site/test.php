<?php


use app\modules\acquiring\models\entity\AcquiringOrder;
use app\modules\payment\models\services\equiring\auth\SberbankAuthBasic;
use app\modules\payment\models\services\equiring\banks\Sberbank;
use app\modules\payment\models\services\equiring\EquiringTerminalService;

$bank = new Sberbank(new SberbankAuthBasic(\Yii::$app->params['acquiring']['sberbank']['login'], \Yii::$app->params['acquiring']['sberbank']['password']));

$terminal = new EquiringTerminalService($bank);

$model = new AcquiringOrder();
$model->identifier_id = "2c88d0f3-7e3e-70e8-b72a-cc515e48041c";

echo "<pre>";
//var_dump($terminal->rollbackMoney($model, 108300));
//var_dump($terminal->cancelPay($model));
var_dump($terminal->decline($model));
//var_dump($terminal->createOrderTest());
echo "</pre>";
