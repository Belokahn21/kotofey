<?php

use app\modules\pets\models\entity\Pets;

$models = Pets::find()->all();

foreach ($models as $pet) {

    $pet->user_id = $pet->status_id;
    $pet->status_id = Pets::STATUS_ON;

    if ($pet->validate() && $pet->update() !== false) {
        echo $pet->name . PHP_EOL;
    }
}

?>