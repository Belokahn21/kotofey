<?php

namespace app\modules\promocode\controllers;

use app\modules\promocode\models\entity\PromocodeUser;
use app\modules\site\controllers\MainBackendController;
use app\widgets\notification\Alert;
use Yii;
use app\modules\promocode\models\entity\Promocode;
use app\modules\promocode\models\search\PromocodeSearchForm;
use yii\web\HttpException;

class PromocodeBackendController extends MainBackendController
{

    public function behaviors()
    {
        $parentAccess = parent::behaviors();
        $oldRules = $parentAccess['access']['rules'];
        $newRules = [['allow' => true, 'actions' => ['clean'], 'roles' => ['Administrator']]];


        $parentAccess['access']['rules'] = array_merge($newRules, $oldRules);

        return $parentAccess;
    }
    public function actionIndex()
    {
        $model = new Promocode();
        $searchModel = new PromocodeSearchForm();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Alert::setSuccessNotify('Промокод успешно добавлен');
                        return $this->refresh();
                    }
                }
            }
        }

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Promocode::findOne($id);

        if (!$model) {
            throw new HttpException(404, 'Такого промокода не существует.');
        }

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->update()) {
                        Alert::setSuccessNotify('Промокод успешно обновлен');
                        return $this->refresh();
                    }
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionClean()
    {
        PromocodeUser::deleteAll();
        Alert::setSuccessNotify('История использования промокодов очищена');
        return $this->redirect(['index']);
    }
}
