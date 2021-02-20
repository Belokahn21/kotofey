<?php
$result = \app\modules\order\models\helpers\OrderDateHelper::getAvailableDates(\app\modules\basket\models\entity\Basket::findAll());


\app\modules\site\models\tools\Debug::p($result);