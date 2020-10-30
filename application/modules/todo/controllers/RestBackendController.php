<?php

namespace app\modules\todo\controllers;


use app\modules\site\models\tools\Debug;
use app\modules\todo\models\entity\TodoList;
use yii\helpers\Json;
use yii\rest\Controller;

class RestBackendController extends Controller
{
    public $modelClass = 'app\modules\todo\models\entity\TodoList';

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
            'add' => ['POST'],
        ];
    }

    /**
     * @var $model TodoList
     */
    public function actionAdd()
    {
        $response = [
            'status' => 200
        ];

        $model = new $this->modelClass;

        if ($model->load(\Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->save()) {
                    return Json::encode($response);
                }
            }
        }
    }

    public function actionGet()
    {
        return Json::encode($this->modelClass::find()->all());
    }
}
