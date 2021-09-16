<?php

namespace app\modules\order\controllers;

use yii\filters\Cors;
use yii\rest\ActiveController;

class StatusRestController extends ActiveController
{
    public $modelClass = 'app\modules\order\models\entity\OrderStatus';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => Cors::className()
        ];
        return $behaviors;
    }
}