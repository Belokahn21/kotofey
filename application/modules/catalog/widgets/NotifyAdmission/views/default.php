<?php

use yii\helpers\Url;
use app\modules\catalog\models\helpers\NotifyAdmissionHelper;

/* @var $model \app\modules\catalog\models\entity\NotifyAdmission
 * @var $product \app\modules\catalog\models\entity\Product
 * @var $this \yii\web\View
 */

$isAlreadyAdmission = false;

if (NotifyAdmissionHelper::isAlreadyObserver($product->id, Yii::$app->user->identity->email)) {
    $isAlreadyAdmission = true;
}
?>

<div class="product-admission-react" data-form-action="<?= Url::to(['/save-notify-admission']); ?>" data-product-id="<?= $product->id; ?>"></div>
