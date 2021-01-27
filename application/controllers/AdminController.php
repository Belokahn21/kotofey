<?php

namespace app\controllers;

use app\modules\site\controllers\MainBackendController;
use Yii;
use app\modules\search\models\entity\SearchQuery;
use app\modules\site\models\tools\Backup;
use app\widgets\notification\Alert;

class AdminController extends MainBackendController
{
    public $layout = "admin";

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
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


    public function actionCache()
    {
        Yii::$app->cache->flush();
        return $this->redirect('/');
    }
}
