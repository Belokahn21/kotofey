<?php

namespace app\modules\favorite\controllers;


use app\modules\compare\models\entity\Compare;
use app\modules\favorite\models\entity\Favorite;
use yii\helpers\Json;
use yii\rest\Controller;

class RestController extends Controller
{
    public $enableCsrfValidation = false;

    protected function verbs()
    {
        return [
            'add' => ['POST'],
        ];
    }

    public function actionAdd()
    {
        $data = Json::decode(file_get_contents('php://input'));
        $favorite = new Favorite();
        $favorite->add($data['product_id']);
        return Json::encode([
            'status' => 200
        ]);
    }
}