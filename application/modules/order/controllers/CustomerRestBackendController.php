<?php

namespace app\modules\order\controllers;

use yii\rest\ActiveController;

class CustomerRestBackendController extends ActiveController
{
    public $modelClass = 'app\modules\order\models\entity\Customer';
    public $searchModelClass = 'app\modules\order\models\search\CustomerSearchForm';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);

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