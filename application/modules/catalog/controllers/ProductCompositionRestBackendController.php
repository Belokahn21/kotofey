<?php

namespace app\modules\catalog\controllers;


use yii\rest\ActiveController;

class ProductCompositionRestBackendController extends ActiveController
{
    public $modelClass = 'app\modules\catalog\models\entity\CompositionProducts';
    public $modelSearchClass = 'app\modules\catalog\models\entity\CompositionProducts';

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
            'searchModel' => $this->modelSearchClass,
        ];

        return $actions;
    }
}