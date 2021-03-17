<?php

namespace app\modules\promocode\controllers;

use app\modules\promocode\models\entity\Promocode;
use yii\filters\Cors;
use yii\rest\ActiveController;
use yii\rest\Controller;

class RestController extends Controller
{
    public $modelClass = 'app\modules\promocode\models\entity\Promocode';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => Cors::className()
        ];
        return $behaviors;
    }

    protected function verbs()
    {
        $verbs = parent::verbs();
        $verbs['index'] = ['GET'];
        $verbs['view'] = ['GET'];
        return $verbs;
    }

    public function actionIndex()
    {
        $models = $this->modelClass::find()->all();

        return $this->asJson([
            'status' => 200,
            'item' => $models
        ]);
    }

    public function actionView($id)
    {
        $model = $this->modelClass::findOneByCode($id);

        return $this->asJson([
            'status' => 200,
            'item' => $model
        ]);
    }
}