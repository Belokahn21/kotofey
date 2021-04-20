<?php

namespace app\modules\media\controllers;

use app\modules\media\models\search\MediaSearch;
use app\modules\site\controllers\MainBackendController;
use yii\web\HttpException;

class MediaBackendController extends MainBackendController
{
    public $modelClass = 'app\modules\media\models\entity\Media';

    public function actionIndex()
    {
        $searchModel = new MediaSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException('Элемент не найден');
    }

    public function actionDelete($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException('Элемент не найден');

//        if ($model->delete()) Alert::setSuccessNotify('Медиа успешно удалено');

        return $this->redirect(['index']);
    }
}
