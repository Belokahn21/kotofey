<?php

namespace app\modules\acquiring\controllers;

use yii\rest\ActiveController;

class RestController extends ActiveController
{
    public $modelClass = 'app\modules\order\models\entity\Order';

    protected function verbs()
    {
        return [
            'index' => ['GET'],
            'show' => ['GET'],
            'create' => ['POST'],
            'delete' => ['DELETE'],
        ];
    }

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function actionIndex()
    {
        return $this->modelClass::find()->all();
    }

    public function actionShow($id)
    {
        return $this->modelClass::findOne($id);
    }

    public function actionCreate()
    {
    }

    public function actionDelete($id)
    {
        return $this->modelClass::findOne($id)->delete();
    }
}
