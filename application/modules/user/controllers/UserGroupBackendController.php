<?php

namespace app\modules\user\controllers;

use app\modules\rbac\models\entity\AuthItem;
use app\modules\rbac\models\search\AuthItemSearchForm;
use app\modules\site\controllers\MainBackendController;
use Yii;
use app\widgets\notification\Alert;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\HttpException;

class UserGroupBackendController extends MainBackendController
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
        $permissions = Yii::$app->authManager->getPermissions();
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->createRole()) {

                        if ($model->parent) {
                            $model->applyParentGroup($model->name, $model->parent);
                        }

                        return $this->refresh();
                    }
                }
            }
        }
        $searchModel = new AuthItemSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());
        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'permissions' => $permissions,

        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = AuthItem::findOne(['name' => $id])) throw new HttpException(404, 'Группа не найдена');
        if ($model->parents) $model->parent = $model->parents->parent;
        $permissions = Yii::$app->authManager->getPermissions();

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {

                    if ($model->parent) {
                        $model->applyParentGroup($model->name, $model->parent);
                    }

                    if ($model->permissionsGroup) {
                        $model->applyPermissions($model->name, $model->permissionsGroup);
                    }


                    Alert::setSuccessNotify('Группа успешно обновлена.');
                    return $this->refresh();

                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'permissions' => $permissions,
        ]);
    }

    public function actionDelete($id)
    {
        $db = \Yii::$app->db;
        $transaction = $db->beginTransaction();
        if (!Yii::$app->authManager->remove(Yii::$app->authManager->getRole($id))) {
            $transaction->rollBack();
        }
        $transaction->commit();
        Alert::setSuccessNotify('Группа успешно удалена');
        return $this->redirect(['index']);
    }
}