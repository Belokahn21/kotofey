<?php

namespace app\modules\cdek\controllers;


use app\modules\cdek\models\entity\CdekGeo;
use yii\helpers\Json;
use yii\rest\Controller;

class RestCityController extends Controller
{
//    public $modelClass = 'app\modules\todo\models\entity\TodoList';

    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
            ],
        ];
    }

    public function actionGet()
    {
        return Json::encode(CdekGeo::find()->where(['like', 'FullName', \Yii::$app->request->get('name')])->all());
    }
}