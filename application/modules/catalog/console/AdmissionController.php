<?php

namespace app\modules\catalog\console;

use app\modules\catalog\models\entity\NotifyAdmission;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\mailer\models\services\MailService;
use yii\console\Controller;

class AdmissionController extends Controller
{
    public function actionSend()
    {
        $module = \Yii::$app->getModule('catalog');
        $members = NotifyAdmission::find()->where(['is_active' => true])->all();
        if (empty($module->admission_event_id)) return false;

        foreach ($members as $member) {
            if (!$product = Product::findOne($member->product_id)) continue;

            $mailer = new MailService();
            $mailer->sendEvent($module->admission_event_id, [
                'EMAIL_FROM' => 'info@kotofey.store',
                'EMAIL_TO' => $member->email,
                'NAME' => $product->name,
                'LINK' => ProductHelper::getDetailUrl($product),
            ]);

            $member->is_active = false;
            if (!$member->validate() || $member->update() === false) print_r($member->getErrors());
        }
    }
}