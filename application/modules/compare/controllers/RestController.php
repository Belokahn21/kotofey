<?php

namespace app\modules\compare\controllers;

use app\modules\compare\models\entity\Compare;
use app\modules\compare\models\helpers\CompareHelper;
use yii\rest\Controller;

class RestController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];

        return $behaviors;
    }

    public function actionCreate()
    {
        $data = \Yii::$app->request->post();
        $compare = new Compare();
        $compare->product_id = $data['product_id'];
        $compare->save();
        return CompareHelper::isComparing($data['product_id']);
    }
}