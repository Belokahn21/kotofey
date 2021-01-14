<?php

namespace app\modules\menu\controllers;


use app\modules\site\controllers\MainBackendController;
use app\widgets\notification\Alert;
use yii\web\HttpException;

class MenuItemsBackendController extends MainBackendController
{
    public $modelClass = 'app\modules\menu\models\entity\MenuItem';

    public function actionIndex()
    {
        $model = new $this->modelClass();

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate && $model->save()) {
                    Alert::setSuccessNotify('Пункт меню успешно добавлен');
                    return $this->refresh();
                }
            }
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate && $model->update()) {
                    Alert::setSuccessNotify('Пункт меню успешно обновлен');
                    return $this->refresh();
                }
            }
        }
        return $this->render('update');
    }

    public function actionDelete($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');

        if ($model->delete()) Alert::setSuccessNotify('Пункт меню успешно удален');

        return $this->redirect(['index']);
    }
}