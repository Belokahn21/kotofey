<?php

namespace app\modules\user\controllers;

use yii\helpers\Json;
use yii\rest\Controller;

class RestBackendController extends Controller
{
    public $modelClass = 'app\modules\user\models\entity\User';

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items'
    ];

    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
            ],
        ];
    }

    protected function verbs()
    {
        return [
            'get' => ['GET'],
        ];
    }

    public function actionGet()
    {
        return Json::encode($this->modelClass::find()->all());
    }
}