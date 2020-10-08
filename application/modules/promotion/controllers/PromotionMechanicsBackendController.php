<?php

namespace app\modules\promotion\controllers;

use app\modules\promotion\models\entity\Promotion;
use app\modules\promotion\models\entity\PromotionMechanics;
use app\modules\promotion\models\search\PromotionMechanicsSearch;
use yii\web\Controller;

class PromotionMechanicsBackendController extends Controller
{
    public $layout = '@app/views/layouts/admin';

    public function actionIndex()
    {
        $model = new PromotionMechanics();
        $searchModel = new PromotionMechanicsSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
