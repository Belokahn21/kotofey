<?php

namespace app\modules\user\controllers;

use Yii;
use app\models\rbac\AuthItem;
use app\models\search\PermissionsSearchForm;
use yii\web\Controller;

class UserPermissionBackendController extends Controller
{
    public $layout = '@app/views/layouts/admin';

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