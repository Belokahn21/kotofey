<?php

namespace app\modules\bot\controllers;

use app\models\tool\Debug;
use app\modules\bot\models\methods\Message;
use app\modules\bot\models\service\BotRequestService;
use yii\helpers\Json;
use yii\web\Controller;

class VkController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $request = Json::decode(file_get_contents('php://input'));

        $request = new BotRequestService($request);

        if ($request->isConfirm()) {
            return "1f688e0f";
        }

        if ($request->isMessage()) {
            $message = new Message();
            $message->send("hello world", [
                'user_id' => \Yii::$app->params['vk']['adminVkontakteId']
            ]);
        }

        return false;
    }
}
