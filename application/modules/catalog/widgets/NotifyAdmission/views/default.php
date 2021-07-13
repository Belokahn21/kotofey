<?php

use yii\helpers\Url;
use app\modules\catalog\models\helpers\NotifyAdmissionHelper;

/* @var $model \app\modules\catalog\models\entity\NotifyAdmission
 * @var $product \app\modules\catalog\models\entity\Offers
 * @var $this \yii\web\View
 */

$isAlreadyAdmission = false;

if (!Yii::$app->user->isGuest) {
    if (NotifyAdmissionHelper::isAlreadyObserver($product->id, Yii::$app->user->identity->email)) {
        $isAlreadyAdmission = true;
    }
}
?>

<div class="product-admission-react" data-isAlreadyAdmission="<?= $isAlreadyAdmission; ?>" data-form-action="<?= Url::to(['/save-notify-admission']); ?>" data-product-id="<?= $product->id; ?>"></div>
