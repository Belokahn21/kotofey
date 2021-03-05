<?php


namespace app\modules\user\controllers;

use yii\rest\ActiveController;

class RestController extends ActiveController
{
    public $modelClass = 'app\modules\user\models\entity\User';

    protected function verbs()
    {
        return [
            'get' => ['GET'],
            'add' => ['POST'],
            'delete' => ['DELETE'],
        ];
    }

    public function actionGet($id = null)
    {
        $data = [];

        if ($id) {
            array_push($data, $this->modelClass::findOne($id));
        }

        $data = $this->modelClass::find()->all();


        return [
            'status' => 200,
            'items' => $data
        ];
    }
}