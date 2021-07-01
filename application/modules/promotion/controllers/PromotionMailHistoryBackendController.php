<?php

namespace app\modules\promotion\controllers;

use app\modules\promotion\models\search\PromotionMailHistorySearch;
use app\modules\site\controllers\MainBackendController;

class PromotionMailHistoryBackendController extends MainBackendController
{
    public function actionIndex()
    {
        $searchModel = new PromotionMailHistorySearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}