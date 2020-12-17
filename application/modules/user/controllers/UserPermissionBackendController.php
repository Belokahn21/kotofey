<?php

namespace app\modules\user\controllers;

use app\modules\site\controllers\MainBackendController;
use Yii;
use app\modules\rbac\models\entity\AuthItem;
use app\modules\rbac\models\search\PermissionsSearchForm;
use yii\filters\AccessControl;

class UserPermissionBackendController extends MainBackendController
{
    public $layout = '@app/views/layouts/admin';


    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                ['allow' => true, 'actions' => ['index', 'update', 'delete'], 'roles' => ['Administrator']],
                ['allow' => false],
            ],
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        $model = new AuthItem();
        $searchModel = new PermissionsSearchForm();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->createPermission()) {
                        return $this->refresh();
                    }
                }
            }
        }
        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    public function actionUpdate($id)
    {
    }

    public function actionDelete($id)
    {
    }
}