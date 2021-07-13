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
        $models = ProductElastic::find()->query(['match' => ['name' => 'sirius']])->limit(10000)->all();
        echo count($models);
    }

    public function actionIndex()
    {
        $models = Product::find()->all();
        foreach ($models as $model) {
            $el = new ProductElastic();
            $el->setPrimaryKey($model->id);
            $el->_id = $model->id;
            $el->name = $model->name;

            if ($el->insert()) {
                echo $model->name . PHP_EOL;
            }
        }
    }

    public function actionClearCache()
    {
        \Yii::$app->cache->flush();
    }
}
