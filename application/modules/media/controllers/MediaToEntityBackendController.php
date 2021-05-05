<?php


namespace app\modules\media\controllers;


use app\modules\media\models\entity\MediaToEntity;
use app\modules\media\models\search\MediaToEntitySearch;
use app\modules\site\controllers\MainBackendController;

class MediaToEntityBackendController extends MainBackendController
{
    public function actionIndex()
    {
        $model = new MediaToEntity();
        $searchModel = new MediaToEntitySearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());


        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}