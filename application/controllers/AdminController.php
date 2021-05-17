<?php

namespace app\controllers;

use app\modules\site\controllers\MainBackendController;
use app\modules\site\models\tools\Debug;
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



    public function behaviors()
    {
        //todo сделать сервис по добавлению доступов
        $parentAccess = parent::behaviors();
        $oldRules = $parentAccess['access']['rules'];
        $newRules = [['allow' => true, 'actions' => ['discount-clean'], 'roles' => ['Administrator']]];
        $newRules = [['allow' => true, 'actions' => ['copy'], 'roles' => ['Administrator', 'Content']]];
        $newRules = [['allow' => true, 'actions' => ['index'], 'roles' => ['Administrator']]];
        $newRules = [['allow' => true, 'actions' => ['index', 'update'], 'roles' => ['Content']]];

        $parentAccess['access']['rules'] = array_merge($newRules, $oldRules);

        return $parentAccess;
    }

    public function actionCache()
    {
        Yii::$app->cache->flush();
        return $this->redirect('/');
    }
}
