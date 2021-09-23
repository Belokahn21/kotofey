<?php

namespace app\modules\catalog\controllers;

use yii\rest\ActiveController;

class CategoryRestController extends ActiveController
{
    public $modelClass = 'app\modules\catalog\models\entity\ProductCategory';
    public $searchModelClass = 'app\modules\catalog\models\search\ProductCategorySearchForm';

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