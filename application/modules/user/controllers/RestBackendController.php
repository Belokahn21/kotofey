<?php

namespace app\modules\user\controllers;

use yii\rest\ActiveController;

class RestBackendController extends ActiveController
{
    public $modelClass = 'app\modules\user\models\entity\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];

        return $behaviors;
    }
}