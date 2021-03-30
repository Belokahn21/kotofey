<?php


namespace app\modules\site\controllers;


class SettingsBackendController extends MainBackendController
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
    }
}