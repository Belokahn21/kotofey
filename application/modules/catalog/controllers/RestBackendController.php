<?php

namespace app\modules\catalog\controllers;

use yii\filters\Cors;
use yii\rest\ActiveController;

class RestBackendController extends ActiveController
{
    public $modelClass = 'app\modules\catalog\models\entity\Product';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => Cors::className()
        ];
        return $behaviors;
    }
}