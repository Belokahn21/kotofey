<?php

namespace app\modules\search\controllers;

use app\modules\search\models\services\ElasticsearchService;
use app\modules\site\controllers\MainBackendController;
use app\modules\user\models\tool\BehaviorsRoleManager;
use app\widgets\notification\Alert;

class ElasticsearchBackendController extends MainBackendController
{
    public function behaviors()
    {
        $parentAccess = parent::behaviors();

        BehaviorsRoleManager::extendRoles($parentAccess['access']['rules'], [
            ['allow' => true, 'actions' => ['re-index',], 'roles' => ['Administrator']]
        ]);

        return $parentAccess;
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionReIndex()
    {
        $elastic_service = new ElasticsearchService();
        $elastic_service->reIndex();

        Alert::setSuccessNotify("Индекс {$elastic_service->count_all_success} из {$elastic_service->count_all_products} элементов успешно пересоздан.");
        return $this->redirect(['index']);
    }
}