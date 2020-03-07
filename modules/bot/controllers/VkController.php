<?php

namespace app\modules\bot\controllers;

use app\models\tool\Debug;
use yii\web\Controller;

class VkController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        try {
            $request = file_get_contents('php://input');
            Debug::printFile($request);
        } catch (\Exception $exception) {
        }

        return "1f688e0f";
    }
}
