<?php

namespace app\modules\catalog\controllers;


use app\modules\catalog\models\entity\ProductCategory;
use app\modules\catalog\models\entity\PropertiesVariants;
use app\modules\catalog\models\helpers\ProductHelper;
use yii\helpers\Json;
use app\modules\catalog\models\entity\Product;
use yii\rest\ActiveController;
use yii\rest\Controller;

class RestController extends ActiveController
{
    public $modelClass = 'app\modules\catalog\models\entity\Product';
    public $searchModelClass = 'app\modules\catalog\models\search\ProductSearchForm';

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['dataFilter'] = [
            'class' => \yii\data\ActiveDataFilter::class,
            'searchModel' => $this->searchModelClass,
        ];
        $actions['index']['prepareDataProvider'] = function ($action) {
            $model = new $this->searchModelClass();
            $model->load(\Yii::$app->request->queryParams);
            return $model->search(\Yii::$app->request->queryParams);
        };

        return $actions;
    }
}