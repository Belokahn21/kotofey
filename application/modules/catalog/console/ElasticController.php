<?php

namespace app\modules\catalog\console;

use app\modules\catalog\models\entity\virtual\ProductElastic;
use app\modules\search\models\services\ElasticsearchService;
use yii\console\Controller;

class ElasticController extends Controller
{
    public function actionSearch()
    {
        //todo docker run -p 9200:9200 -p 9300:9300 -e "discovery.type=single-node" docker.elastic.co/elasticsearch/elasticsearch:7.13.3
        //todo поиск по логике
        //todo https://codedzen.ru/elasticsearch-urok-6-3-poisk/
        //todo https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-query.html
        $models = ProductElastic::find()->query(['multi_match' => ['query' => 'клетки для грызунов', 'fields' => ['name'], 'operator' => 'and']])->limit(10000)->all();
        foreach ($models as $model) {
            echo $model->id . ' = ' . $model->name . PHP_EOL;
        }
        echo count($models);
    }

    public function actionIndex()
    {
        $elastic_service = new ElasticsearchService();
        $elastic_service->reIndex();

        if ($elastic_service->count_all_success > 0) {
            echo $elastic_service->count_all_success . ":OK";
        }
    }
}