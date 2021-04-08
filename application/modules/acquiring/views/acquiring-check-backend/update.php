<?php

use app\modules\acquiring\models\services\fiscalisation\FiscalisationService;
use app\modules\site\models\tools\Debug;

/* @var $this \yii\web\View
 * @var $model \app\modules\acquiring\models\entity\AcquiringOrderCheck
 * @var $actionForm \app\modules\acquiring\models\forms\AcquiringForm
 */

$fs = new FiscalisationService();

Debug::p($fs->getCheckStatusByCheckId($model->identifier_id));
?>
