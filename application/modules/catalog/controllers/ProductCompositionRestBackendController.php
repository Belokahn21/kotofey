<?php

namespace app\modules\catalog\controllers;


use yii\rest\ActiveController;

class ProductCompositionRestBackendController extends ActiveController
{
    public $modelClass = 'app\modules\catalog\models\entity\CompositionProducts';
    public $modelSearchClass = 'app\modules\catalog\models\search\CompositionProductSearchForm';

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
        $actions['index']['prepareDataProvider'] = function ($action) {
            $model = new $this->modelSearchClass();
            $model->load(\Yii::$app->request->queryParams);
            return $model->search(\Yii::$app->request->queryParams);
        };

        return $actions;
    }
}