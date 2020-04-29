<?php

use app\models\entity\Geo;

?>
Ваш город
<div><?= Geo::findOne($_SESSION['city_id'])->name; ?></div>