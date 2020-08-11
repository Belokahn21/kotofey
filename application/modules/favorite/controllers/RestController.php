<?php

namespace app\modules\favorite\controllers;


use app\modules\compare\models\entity\Compare;
use app\modules\favorite\models\entity\Favorite;
use yii\rest\Controller;

class RestController extends Controller
{
    protected function verbs()
    {
        return [
            'add' => ['POST'],
        ];
    }

    public function actionAdd()
    {
        $data = file_get_contents('php://input');
        print_r($data);

        exit();
        $favorite = new Favorite();
        $favorite->add($data['product_id']);
        return true;
    }
}