<?php

namespace app\modules\pets\controllers;

use yii\rest\ActiveController;

class AnimalRestController extends ActiveController
{
    public $modelClass = 'app\modules\pets\models\entity\Animal';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];

        return $behaviors;
    }
}