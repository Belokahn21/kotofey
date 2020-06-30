<?php

namespace app\modules\user\controllers;

use app\modules\rbac\models\entity\AuthItem;
use app\modules\rbac\models\search\AuthItemSearchForm;
use Yii;
use app\widgets\notification\Alert;
use yii\web\Controller;
use yii\web\HttpException;

class UserGroupBackendController extends Controller
{
    public $layout = '@app/views/layouts/admin';

    public function actionIndex()
    {
        $model = new AuthItem();
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->createRole()) {
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

        ]);
    }

    public function actionUpdate($id)
    {
        $model = AuthItem::findOne(['name' => $id]);

        if (!$model) {
            throw new HttpException(404, 'Группа не найдена');
        }


        return $this->render('update', [
            'model' => $model
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