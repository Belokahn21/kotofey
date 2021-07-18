<?php

namespace app\modules\search\controllers;

use app\modules\search\models\search\SearchHistorySearchForm;
use app\modules\site\controllers\MainBackendController;
use app\modules\user\models\tool\BehaviorsRoleManager;
use app\widgets\notification\Alert;
use yii\web\HttpException;

class SearchHistoryBackendController extends MainBackendController
{
    public $modelClass = 'app\modules\search\models\entity\SearchQuery';

    public function behaviors()
    {
        $parentAccess = parent::behaviors();

        BehaviorsRoleManager::extendRoles($parentAccess['access']['rules'], [
            ['allow' => true, 'actions' => ['clean'], 'roles' => ['Administrator']]
        ]);

        return $parentAccess;
    }

    public function actionIndex()
    {
        $model = $this->modelClass;
        $searchModel = new SearchHistorySearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = $this->getModel($id)) throw new HttpException(404, 'Элемент не найден');
        return $this->render('update');
    }

    public function actionDelete($id)
    {
        if (!$model = $this->getModel($id)) throw new HttpException(404, 'Элемент не найден');

        if ($model->delete()) Alert::setSuccessNotify('Элемент успешно удален');

        return $this->redirect(['index']);
    }

    public function actionClean()
    {
        if ($this->modelClass::deleteAll()) Alert::setSuccessNotify('История поиска полностью очищена');
        return $this->redirect(['index']);
    }

    private function getModel($id)
    {
        return $this->modelClass::findOne($id);
    }
}