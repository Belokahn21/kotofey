<?php

namespace app\controllers;

use Yii;
use app\modules\search\models\entity\SearchQuery;
use app\models\tool\Backup;
use app\widgets\notification\Alert;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class AdminController extends Controller
{
    public $layout = "admin";

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['Administrator', 'Developer'],
                    ],
                    [
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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
        $last_search = SearchQuery::find()->orderBy(['created_at' => SORT_DESC])->limit(5)->all();

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

        return $this->render('index', [
            'last_search' => $last_search
        ]);
    }


    public function actionCache()
    {
        Yii::$app->cache->flush();
        return $this->redirect('/');
    }
}
