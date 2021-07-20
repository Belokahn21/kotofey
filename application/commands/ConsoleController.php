<?php

namespace app\commands;

use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\virtual\ProductElastic;
use app\modules\vendors\models\entity\Vendor;
use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionRun($name = null)
    {
        //todo https://codedzen.ru/elasticsearch-urok-6-3-poisk/
        $models = ProductElastic::find()->query(['match' => ['name' => 'Yorkshire puppy']])->limit(10000)->all();
        foreach ($models as $model) {
            echo $model->name . PHP_EOL;
        }
        echo count($models);
    }

    public function actionIndex()
    {
        ProductElastic::deleteIndex();
        ProductElastic::createIndex();
        $models = Product::find()->all();
//        $models = Product::find()->limit(10)->all();
        foreach ($models as $model) {
            $el = new ProductElastic();
            $el->setPrimaryKey($model->id);
            $el->_id = $model->id;
            $el->name = $model->name;

            if ($el->insert()) {
                echo $model->name . PHP_EOL;
            }
        }
//        ProductElastic::createIndex();
    }

    public function actionClearCache()
    {
        \Yii::$app->cache->flush();
    }
}
