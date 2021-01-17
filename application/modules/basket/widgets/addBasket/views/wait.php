<?php

use app\modules\catalog\widgets\NotifyAdmission\NotifyAdmissionWidget;

/* @var $product \app\modules\catalog\models\entity\Product
 * @var $showOrderButton boolean
 */
?>
<div class="product-status wait">
    <div>Ожидается поступление</div>

    <?php if ($showOrderButton): ?>
        <?= NotifyAdmissionWidget::widget([
            'product' => $product
        ]) ?>
    <?php endif; ?>
</div>