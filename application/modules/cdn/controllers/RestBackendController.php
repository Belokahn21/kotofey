<?php


namespace app\modules\cdn\controllers;

use app\modules\cdn\models\components\CloudinaryComponent;
use app\modules\site\models\tools\Debug;
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

    public function actionDelete($id)
    {
        $result = CloudinaryComponent::getInstance()->removeResource($id);
        Debug::p($result);
    }
}