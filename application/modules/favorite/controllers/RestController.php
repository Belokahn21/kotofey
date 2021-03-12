<?php

namespace app\modules\favorite\controllers;

use app\modules\favorite\models\entity\Favorite;
use yii\helpers\Json;
use yii\rest\ActiveController;

class RestController extends ActiveController
{
    public $modelClass = 'app\modules\favorite\models\entity\Favorite';

    protected function verbs()
    {
        return [
            'index' => ['GET'],
            'show' => ['GET'],
            'create' => ['POST'],
            'delete' => ['DELETE'],
        ];
    }

    public function actionIndex()
    {
//        return $this->modelClass::find()->all();
    }

    public function actionShow($id)
    {
//        return $this->modelClass::findOne($id);
    }

    public function actionCreate()
    {
        $data = \Yii::$app->request->post();

        $favorite = new Favorite();
        $favorite->add($data['product_id']);

        return Json::encode([
            'status' => 200
        ]);
    }

    public function actionDelete($id)
    {
        $favorite = new $this->modelClass();
        $favorite->delete($id);

        return Json::encode([
            'status' => 200
        ]);
    }
}