<?php

namespace app\commands;

use app\modules\bonus\models\entity\UserBonusHistory;
use app\modules\catalog\models\entity\Properties;
use app\modules\catalog\models\entity\PropertiesProductValues;
use app\modules\catalog\models\entity\PropertiesVariants;
use app\modules\catalog\models\entity\SaveInformersValues;
use app\modules\catalog\models\entity\SaveProductProperties;
use app\modules\catalog\models\entity\SaveProductPropertiesValues;
use app\modules\catalog\models\entity\TypeProductProperties;
use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\catalog\models\entity\Product;
use app\modules\order\models\entity\Order;
use app\modules\settings\models\helpers\MarkupHelpers;
use app\modules\site\models\tools\Debug;
use app\modules\user\models\entity\User;
use app\modules\vendors\models\entity\Vendor;
use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionRun($arg = null)
    {
        UserBonusHistory::deleteAll();
        foreach (User::find()->all() as $user) {
            $obj = new UserBonusHistory();
            $obj->count = 0;
            $obj->is_active = 1;
            $obj->bonus_account_id = $user->phone;
            $obj->reason = "Аккаунт создан";
            var_dump($obj->validate() && $obj->save());
        }
    }

    public function actionClearCache()
    {
        \Yii::$app->cache->flush();
    }
}
