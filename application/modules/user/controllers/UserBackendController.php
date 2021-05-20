<?php

namespace app\modules\user\controllers;

use app\modules\site\controllers\MainBackendController;
use app\modules\site\models\tools\Debug;
use app\modules\user\models\search\UserSearchForm;
use Yii;
use app\modules\user\models\entity\User;
use app\modules\rbac\models\entity\AuthAssignment;
use app\modules\rbac\models\entity\AuthItem;
use app\widgets\notification\Alert;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;

class UserBackendController extends MainBackendController
{
    public $layout = '@app/views/layouts/admin';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                ['allow' => true, 'actions' => ['index', 'update', 'delete', 'auth'], 'roles' => ['Administrator']],
                ['allow' => false],
            ],
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        $model = new User(['scenario' => User::SCENARIO_INSERT]);
        $authManager = Yii::$app->authManager;
        $searchModel = new UserSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());
        $groups = Yii::$app->authManager->getRoles();

        if (\Yii::$app->request->isPost) {

            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    $model->setPassword($model->password);
                    $model->generateAuthKey();
                    $transaction = Yii::$app->db->transaction;
                    $transaction->begin();

                    if ($model->save()) {

                        if ($model->groups) {

                            Yii::$app->authManager->revokeAll($model->id);

                            foreach ($model->groups as $group) {
                                $groupModel = $authManager->getRole($group);
                                if ($groupModel) {
                                    $authManager->assign($groupModel, $model->id);
                                }
                            }

                        }

                        Alert::setSuccessNotify('Пользователь успешно создан');
                        $transaction->commit();
                        return $this->refresh();
                    }
                }
            }
            return $this->refresh();
        }

        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'groups' => $groups,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = User::findOne($id);
        $model->scenario = User::SCENARIO_UPDATE;
        $groups = Yii::$app->authManager->getRoles();
        $authManager = Yii::$app->authManager;


        // обновить юзера
        if (\Yii::$app->request->isPost) {

            if ($model->load(\Yii::$app->request->post())) {

                if ($model->validate()) {

                    if (!empty($model->new_password)) {
                        $model->setPassword($model->new_password);
                    }


                    if ($model->groups) {

                        Yii::$app->authManager->revokeAll($model->id);

                        foreach ($model->groups as $group) {
                            $groupModel = $authManager->getRole($group);
                            if ($groupModel) {
                                $authManager->assign($groupModel, $model->id);
                            }
                        }

                    }

                    if ($model->update() !== false) {
                        Alert::setSuccessNotify("Информация о пользователе успешно обновлена");
                        return $this->refresh();
                    }
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'groups' => $groups,
        ]);
    }

    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('removeUser')) throw new ForbiddenHttpException('Доступ запрещён');

        if (User::findOne($id)->delete()) throw new HttpException(404, 'Пользователь удалён');

        return $this->redirect(['index']);
    }

    public function actionAuth($id)
    {
        //todo: настроить права
//        if (!Yii::$app->user->can('adminSigninUser')) throw new ForbiddenHttpException('Доступ запрещён');

        $user = User::findOne($id);
        if ($user) {
            if (Yii::$app->user->login($user)) {
                Alert::setSuccessNotify('Ты авторизовался под ' . $user->email);
            }
        }
        return $this->redirect(['index']);
    }
}
