<?php
//$order = \app\modules\order\models\entity\Order::findOne(798);
//$order = \app\modules\order\models\entity\Order::findOne(802);
//
//$ns = new \app\modules\order\models\service\NotifyService();
//$ns->notifyOrderComplete($order);

use app\modules\pets\models\entity\Pets;

foreach (Pets::find()->all() as $pet) {
    $pet->birthday = date('Y-m-d', strtotime($pet->birthday));

    if ($pet->validate() && $pet->update() !== false) {
        echo $pet->name . PHP_EOL;
    }
}