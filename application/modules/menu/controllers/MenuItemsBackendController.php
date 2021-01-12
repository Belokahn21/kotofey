<?php

namespace app\modules\menu\controllers;


use app\modules\site\controllers\MainBackendController;

class MenuItemsBackendController extends MainBackendController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionUpdate($id)
    {
        return $this->render('update');
    }

    public function actionDelete($id)
    {
        return $this->redirect(['index']);
    }
}