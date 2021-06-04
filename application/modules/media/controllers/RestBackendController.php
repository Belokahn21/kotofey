<?php

namespace app\modules\media\controllers;

use yii\rest\ActiveController;

class RestBackendController extends ActiveController
{
    public $modelClass = 'app\modules\media\models\entity\Media';

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
        $parent = parent::actions();
        unset($parent['create']);
        return $parent;
    }

    public function actionCreate()
    {
        $model = new $this->modelClass();

        if (!$model->load(\Yii::$app->request->post())) throw new \Exception('Данные в модель не были загружен');

        if (!$model->validate() || !$model->save()) return $model->getErrors();

        return $model;
    }
}