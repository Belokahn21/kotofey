<?php


namespace app\modules\user\controllers;

use yii\helpers\Json;
use yii\rest\ActiveController;

class RestController extends ActiveController
{
    public $modelClass = 'app\modules\user\models\entity\User';

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
            'add' => ['POST'],
            'delete' => ['DELETE'],
        ];
    }

    public function actionGet($id = null)
    {
        $data = [];

        if ($id) {
            array_push($data, $this->modelClass::findOne($id));
        } else {
            $data = $this->modelClass::find()->all();
        }


        return Json::encode([
            'status' => 200,
            'items' => $data
        ]);
    }
}