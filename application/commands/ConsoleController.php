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
use app\modules\promocode\models\entity\PromocodeUser;
use app\modules\settings\models\helpers\MarkupHelpers;
use app\modules\site\models\tools\Debug;
use app\modules\user\models\entity\User;
use app\modules\vendors\models\entity\Vendor;
use yii\console\Controller;
use yii\helpers\Inflector;

class ConsoleController extends Controller
{
    public function actionRun($arg = null)
    {
        $models = Product::find()->where(['like', 'name', 'tasty'])->all();
        foreach ($models as $model) {
            $model->scenario = Product::SCENARIO_UPDATE_PRODUCT;
            MarkupHelpers::applyMarkup($model, 40);

            if ($model->validate() && $model->update()) {
                echo $model->name;
                echo PHP_EOL;
            }
        }

    }

    public function actionClearCache()
    {
        \Yii::$app->cache->flush();
    }
}
