<?php

namespace app\modules\site\controllers;

use app\modules\site\models\forms\ConsoleForm;
use app\modules\user\models\tool\BehaviorsRoleManager;
use app\widgets\notification\Alert;

class SiteBackendController extends MainBackendController
{
    public function behaviors()
    {
        $parentAccess = parent::behaviors();

        BehaviorsRoleManager::extendRoles($parentAccess['access']['rules'], [
            ['allow' => true, 'actions' => ['console', 'settings'], 'roles' => ['Administrator']],
        ]);

        return $parentAccess;
    }

    public function actionConsole()
    {
        $console = new ConsoleForm();

        if ($console->load(\Yii::$app->request->post())) {
            if ($console->validate()) {
                if ($console->run()) {
                    Alert::setSuccessNotify('Операция успешно выполнена');
                }
            }
        }

        return $this->render('console', [
            'console' => $console
        ]);
    }
}
