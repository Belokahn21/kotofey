<?php


namespace app\modules\bonus\controllers;

use app\modules\bonus\models\entity\UserBonusHistory;
use yii\helpers\Json;
use yii\rest\ActiveController;

class RestController extends ActiveController
{
    public $modelClass = 'app\modules\bonus\models\entity\UserBonusHistory';

    protected function verbs()
    {
        return [
            'get' => ['GET']
        ];
    }

    public function actionGet($id = null)
    {
        $status = 200;
        $response = [];

        if ($id) {
            $count = UserBonusHistory::find()->where(['bonus_account_id' => $id])->sum('count');
            $response = [
                'status' => $status,
                'count' => $count
            ];
        }

        return Json::encode($response);
    }
}