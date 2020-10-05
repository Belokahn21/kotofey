<?php

namespace app\modules\promotion\controllers;

use app\modules\promotion\models\entity\Promotion;
use yii\web\Controller;

class PromotionBackendController extends Controller
{
    public $layout = '@app/views/layouts/admin';

    public function actionIndex()
    {
        $model = new Promotion();
        return $this->render('index', [
            'model' => $model
        ]);
    }
}
