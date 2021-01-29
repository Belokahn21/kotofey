<?php

namespace app\modules\catalog\controllers;


use app\modules\catalog\models\entity\PropertiesVariants;
use app\modules\catalog\models\entity\SaveInformersValues;
use app\modules\catalog\models\search\PropertiesVariantsSearchForm;
use app\modules\site\controllers\MainBackendController;
use app\modules\site\models\tools\Debug;
use app\modules\user\models\tool\BehaviorsRoleManager;
use app\widgets\notification\Alert;
use yii\web\HttpException;

class ProductPropertiesVariantsBackendController extends MainBackendController
{
    public $layout = '@app/views/layouts/admin';
    public $modelClass = 'app\modules\catalog\models\entity\PropertiesVariants';

    public function behaviors()
    {
        $parentAccess = parent::behaviors();

        BehaviorsRoleManager::extendRoles($parentAccess['access']['rules'], [
            ['allow' => true, 'actions' => ['index', 'update'], 'roles' => ['Content']]
        ]);

        return $parentAccess;
    }

    public function actionIndex()
    {
        $model = new $this->modelClass();
        $searchModel = new PropertiesVariantsSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Alert::setSuccessNotify('Значение свойства добавлено');
                        return $this->refresh();
                    }
                } else {
                    Alert::setErrorNotify(Debug::modelErrors($model));
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
        $model = $this->modelClass::findOne($id);
        if (!$model) {
            throw new HttpException(404, 'Запись не существует');
        }
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->update()) {
                        Alert::setSuccessNotify('Значение свойства обновлено');
                        return $this->refresh();
                    }
                }
            }
        }


        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        if ($this->modelClass::findOne($id)->delete()) {
            Alert::setSuccessNotify('Значение свойства удалено');
        }
        return $this->redirect(['index']);
    }
}