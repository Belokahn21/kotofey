<?php

namespace app\modules\delivery\controllers;

use yii\rest\ActiveController;

class ServiceRestController extends ActiveController
{
    public $modelClass = 'app\modules\delivery\models\entity\DeliveryService';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];

        return $behaviors;
    }
}