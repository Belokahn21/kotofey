<?php

namespace app\modules\site\controllers;

use app\modules\site\models\entity\ModuleSettings;
use app\modules\site\models\forms\ConsoleForm;
use app\modules\site\models\tools\Debug;
use app\modules\user\models\tool\BehaviorsRoleManager;
use app\widgets\notification\Alert;
use yii\web\Controller;

class SiteBackendController extends MainBackendController
{
    public $layout = '@app/views/layouts/admin';


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

    public function actionSettings($id)
    {
        if (!$model = ModuleSettings::find()->where(['module_id' => $id])->all()) $model = new ModuleSettings();

        if (\Yii::$app->hasModule($id)) $module = \Yii::$app->getModule($id);

        return $this->render('settings', [
            'model' => $model,
            'module' => $module
        ]);
    }
}
