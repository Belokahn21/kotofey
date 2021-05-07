<?php

namespace app\modules\catalog\console;

use app\modules\catalog\models\entity\NotifyAdmission;
use app\modules\catalog\models\entity\Product;
use app\modules\mailer\models\services\MailService;
use yii\console\Controller;

class AdmissionController extends Controller
{
    public function actionSend()
    {
        $members = NotifyAdmission::find()->where(['is_active' => true])->all();

        foreach ($members as $member) {
            if (!$product = Product::findOne($member->product_id)) continue;


            $mailer = new MailService();
            $mailer->sendEvent(1, [
                'EMAIL_FROM' => 'info@kotofey.store',
                'EMAIL_TO' => $member->email,
                'NAME' => $product->name,
            ]);

//            echo "send mail - {$product->name}" . PHP_EOL;

//            $member->is_active = false;
            if (!$member->validate() || $member->update() === false) print_r($member->getErrors());
        }
    }
}