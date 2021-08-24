<?php

namespace app\modules\site\controllers;

use app\modules\site\models\tools\Debug;
use app\modules\user\models\entity\User;
use Yii;
use app\modules\site\models\forms\ConsoleForm;
use app\modules\site\models\tools\Backup;
use app\modules\user\models\tool\BehaviorsRoleManager;
use app\widgets\notification\Alert;

class SiteBackendController extends MainBackendController
{
    public function behaviors()
    {
        $parentAccess = parent::behaviors();

        BehaviorsRoleManager::extendRoles($parentAccess['access']['rules'], [
            ['allow' => true, 'actions' => ['console', 'settings','log','log-clear'], 'roles' => ['Administrator']],
        ]);

        return $parentAccess;
    }

    public function actionIndex()
    {

        if (Yii::$app->request->get('save_dump') == 'Y') {
            $backup = new Backup();
            if ($backup->isOverSize()) {
                $backup->clearDumpCatalog();
            }

            $backup->createDumpDatabase();

            if (Yii::$app->request->get('out') == 'Y') {
                $name = Yii::getAlias('@app') . $backup->getNameDirDumps() . $backup->getNameFile();
                header('Content-Type: application/octet-stream');
                header("Content-Transfer-Encoding: Binary");
                header("Content-disposition: attachment; filename=\"" . $backup->getNameFile() . "\"");
                readfile($name);
                exit;
            }

            Alert::setSuccessNotify('Бэкап успешно создан');

            return $this->redirect(['/admin/']);
        }

        return $this->render('index');
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

    public function actionLog()
    {
        $data = @file_get_contents(Yii::getAlias(Debug::DEBUG_FILE_ALIAS_PATH));
        return $this->render('log', [
            'data' => $data
        ]);
    }

    public function actionLogClear()
    {
        unlink(Yii::getAlias(Debug::DEBUG_FILE_ALIAS_PATH));
        return $this->redirect(['site-backend/log']);
    }
}
