<?php

namespace app\modules\logger\controllers;

use app\modules\logger\models\entity\Logger;
use app\modules\logger\models\search\LoggerSearchForm;
use app\modules\site\controllers\MainBackendController;
use app\modules\user\models\tool\BehaviorsRoleManager;
use app\widgets\notification\Alert;
use yii\web\HttpException;

class LogBackendController extends MainBackendController
{
    public $modelClass = 'app\modules\logger\models\entity\Logger';

    public function behaviors()
    {
        $parentAccess = parent::behaviors();

        BehaviorsRoleManager::extendRoles($parentAccess['access']['rules'], [
            ['allow' => true, 'actions' => ['clear'], 'roles' => ['Administrator']],
        ]);

        return $parentAccess;
    }

    public function actionIndex()
    {
        $model = new $this->modelClass();
        $searchModel = new LoggerSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());


        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDelete($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');

        if ($model->delete()) Alert::setSuccessNotify('Запись в логах удалена.');

        return $this->redirect(['index']);
    }

    public function actionClear()
    {
        if (Logger::deleteAll()) Alert::setSuccessNotify('Логи полностью очищены.');

        return $this->redirect(['index']);
    }
}
