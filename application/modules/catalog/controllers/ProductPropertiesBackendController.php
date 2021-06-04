<?php

namespace app\modules\catalog\controllers;


use app\modules\catalog\models\entity\PropertyGroup;
use app\modules\catalog\models\search\ProductPropertiesSearchForm;
use app\modules\site\controllers\MainBackendController;
use app\modules\user\models\tool\BehaviorsRoleManager;
use app\widgets\notification\Alert;
use yii\web\HttpException;

class ProductPropertiesBackendController extends MainBackendController
{
    public $layout = '@app/views/layouts/admin';
    public $modelClass = 'app\modules\catalog\models\entity\Properties';

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
        $searchModel = new ProductPropertiesSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());
        $propertyGroup = PropertyGroup::find()->all();

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Alert::setSuccessNotify('Свойство успешно добавлено');
                        return $this->refresh();
                    }
                }
            }
        }

        return $this->render("index", [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'propertyGroup' => $propertyGroup
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');
        $propertyGroup = PropertyGroup::find()->all();

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->update()) {
                        Alert::setSuccessNotify('Свойство успешно обновлено');
                        return $this->refresh();
                    }
                }
            }
        }

        return $this->render("update", [
            'model' => $model,
            'propertyGroup' => $propertyGroup,
        ]);
    }

    public function actionDelete($id)
    {
        if ($this->modelClass::findOne($id)->delete()) {
            Alert::setSuccessNotify('Свойство товара удалено');
        }

        return $this->redirect(['index']);
    }
}