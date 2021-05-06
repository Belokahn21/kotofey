<?php


namespace app\modules\catalog\controllers;


use yii\rest\ActiveController;

class PropertiesProductValuesRestBackendController extends ActiveController
{
    public $modelClass = 'app\modules\catalog\models\entity\PropertiesProductValues';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];

        return $behaviors;
    }
}