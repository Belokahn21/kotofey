<?php

namespace app\modules\pets\controllers;

use yii\rest\ActiveController;

class BreedRestController extends ActiveController
{
    public $modelClass = 'app\modules\pets\models\entity\Breed';
    public $searchModelClass = 'app\modules\pets\models\search\BreedSearchForm';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

//        unset($behaviors['authenticator']);

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