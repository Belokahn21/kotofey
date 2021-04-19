<?php


namespace app\modules\cdn\controllers;

use app\modules\cdn\models\components\CloudinaryComponent;
use yii\rest\Controller;

class RestBackendController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        $result = CloudinaryComponent::getInstance()->getAllResources();

        return $result->getArrayCopy();
    }
}