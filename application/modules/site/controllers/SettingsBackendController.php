<?php


namespace app\modules\site\controllers;


use app\modules\site\models\entity\ModuleSettings;
use yii\web\HttpException;

class SettingsBackendController extends MainBackendController
{
    public function actionModule($id)
    {
        $module = \Yii::$app->getModule($id);
        $model = new ModuleSettings();

        if (!$module) throw new HttpException(404, 'Модуль не найден');


        return $this->render('module', [
            'module' => $module,
            'model' => $model,
        ]);
    }
}