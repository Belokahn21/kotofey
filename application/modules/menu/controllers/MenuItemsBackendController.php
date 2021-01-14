<?php

namespace app\modules\menu\controllers;


use app\modules\menu\models\entity\Menu;
use app\modules\menu\models\search\MenuItemSearchForm;
use app\modules\site\controllers\MainBackendController;
use app\widgets\notification\Alert;
use yii\web\HttpException;

class MenuItemsBackendController extends MainBackendController
{
    public $modelClass = 'app\modules\menu\models\entity\MenuItem';

    public function actionIndex()
    {
        $model = new $this->modelClass();
        $listMenu = Menu::find()->all();
        $searchModel = new MenuItemSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate() && $model->save()) {
                    Alert::setSuccessNotify('Пункт меню успешно добавлен');
                    return $this->refresh();
                }
            }
        }

        return $this->render('index', [
            'model' => $model,
            'listMenu' => $listMenu,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');
        $listMenu = Menu::find()->all();

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate() && $model->update()) {
                    Alert::setSuccessNotify('Пункт меню успешно обновлен');
                    return $this->refresh();
                }
            }
        }
        return $this->render('update', [
            'model' => $model,
            'listMenu' => $listMenu,
        ]);
    }

    public function actionDelete($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');

        if ($model->delete()) Alert::setSuccessNotify('Пункт меню успешно удален');

        return $this->redirect(['index']);
    }
}