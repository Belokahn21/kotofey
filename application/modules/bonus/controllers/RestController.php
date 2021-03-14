<?php


namespace app\modules\bonus\controllers;

use yii\rest\ActiveController;

class RestController extends ActiveController
{
    public $modelClass = 'app\modules\bonus\models\entity\UserBonusHistory';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['view']);

        return $actions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
        ];

        return $behaviors;
    }

    public function actionView($id)
    {
        return new \yii\data\ActiveDataProvider([
            'query' => $this->modelClass::find()->where(['bonus_account_id' => $id]),
        ]);
    }
}