<?php
/* @var $vendros \app\modules\order\models\entity\OrdersItems[] */

use yii\helpers\Html;
use app\modules\vendors\models\entity\Vendor;
use app\modules\site\models\helpers\PhoneHelper;
use app\modules\order\models\helpers\OrderHelper;

?>


<?php if ($vendros): ?>
    <ul>
        <?php foreach ($vendros as $vendorId => $product): ?>
            <?php
            $vendor = Vendor::findOne($vendorId);


            if ($vendor->how_send_order != Vendor::SEND_ORDER_VARIANT_WA) {
                continue;
            }

            if (!$vendor->phone) {
                continue;
            }

            $whatsappMessage = OrderHelper::getWhatsappMessage($vendros[$vendorId]);
            $phone = PhoneHelper::formatPhone($vendor->phone);
            ?>
            <li>Поставщк: <?= $vendor->name; ?>(<?= count($vendros[$vendorId]); ?>) <?= Html::a('Написать менеджеру', 'https://api.whatsapp.com/send?phone=' . $phone . '&text=' . $whatsappMessage, ['target' => '_blank']); ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>