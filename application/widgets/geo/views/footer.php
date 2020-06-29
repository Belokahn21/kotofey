<?php

use app\modules\geo\models\entity\Geo;

?>
Ваш город
<div><?= Geo::findOne($_SESSION['city_id'])->name; ?></div>