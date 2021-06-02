<?php

namespace app\modules\media\controllers;


use app\modules\site\models\tools\Debug;
use yii\rest\ActiveController;
use yii\rest\Controller;

class RestBackendController extends ActiveController
//class RestBackendController extends Controller
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

//    public function actionCreate()
//    {
//        Debug::p($_FILES);
//        exit();
//    }
}