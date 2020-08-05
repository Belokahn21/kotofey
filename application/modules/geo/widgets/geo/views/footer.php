<?php

use app\modules\geo\models\entity\Geo;

?>
<a class="footer-contact__link address" href="javascript:void(0);">
	<?= Geo::findOne($_SESSION['city_id'])->address; ?> <img src="/upload/images/gps.png">
</a>