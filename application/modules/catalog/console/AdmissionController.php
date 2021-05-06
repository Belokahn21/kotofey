<?php

namespace app\modules\catalog\console;

use app\modules\catalog\models\entity\NotifyAdmission;
use app\modules\catalog\models\entity\Product;
use yii\console\Controller;

class AdmissionController extends Controller
{
    public function actionSend()
    {
        $members = NotifyAdmission::find()->where(['is_active' => true])->all();

        foreach ($members as $member) {
            if (!$product = Product::findOne($member->product_id)) continue;

            echo "send mail - {$product->name}" . PHP_EOL;

            $member->is_active = false;
            if (!$member->validate() || !$member->update()) print_r($member->getErrors());
        }
    }
}