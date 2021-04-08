<?php


namespace app\modules\site\controllers;

use app\modules\site\models\tools\Debug;
use app\modules\user\models\tool\BehaviorsRoleManager;
use Yii;
use yii\web\HttpException;
use app\widgets\notification\Alert;
use app\modules\site\models\entity\ModuleSettings;

class SettingsBackendController extends MainBackendController
{
    public function behaviors()
    {
        $parentAccess = parent::behaviors();

        BehaviorsRoleManager::extendRoles($parentAccess['access']['rules'], [
            ['allow' => true, 'actions' => ['module'], 'roles' => ['Administrator']],
        ]);

        return $parentAccess;
    }

    public function actionModule($id)
    {
        $module = \Yii::$app->getModule($id);
        $model = new ModuleSettings();

        if (!$module) throw new HttpException(404, 'Модуль не найден');


        if (Yii::$app->request->isPost) {
            if ($data = Yii::$app->request->post('ModuleSettings')) {

                ModuleSettings::deleteAll(['module_id' => $id]);
                foreach ($data as $paramKey => $arPost) {
                    $obj = new ModuleSettings();
                    $obj->setAttributes($arPost);

                    if (!$obj->validate() || !$obj->save()) {
                        Alert::setErrorNotify('Не удалось сохранить значения');
                        return false;
                    }
                }

                Yii::$app->cache->delete('settings:' . $id);
                Alert::setErrorNotify('Настройки модуля обновлены');
                return $this->refresh();
            }
        }

        return $this->render('module', [
            'module' => $module,
            'model' => $model,
        ]);
    }
}