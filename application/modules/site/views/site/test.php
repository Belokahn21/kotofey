<?php
$ms = new \app\modules\marketplace\models\api\OzonApi();
\app\modules\site\models\tools\Debug::p($ms->listCategoryCharacteristic());
