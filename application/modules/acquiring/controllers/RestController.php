<?php

namespace app\modules\acquiring\controllers;

use app\modules\order\models\entity\Order;
use yii\rest\ActiveController;
use yii\rest\Controller;

class RestController extends ActiveController
{
    public $modelClass = 'app\modules\order\models\entity\Order';

    protected function verbs()
    {
        return [
            'all' => ['GET'],
            'one' => ['GET'],
            'create' => ['POST'],
            'delete' => ['DELETE'],
        ];
    }

    public function actionAll()
    {
        return $this->modelClass::find()->all();
    }

    public function actionOne($id)
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
