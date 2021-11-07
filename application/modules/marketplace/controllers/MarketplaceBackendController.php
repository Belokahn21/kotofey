<?php

namespace app\modules\marketplace\controllers;

use app\modules\marketplace\models\form\actions\MarketplaceCreateProductForm;
use app\modules\marketplace\models\services\MarketplaceService;
use app\modules\user\models\tool\BehaviorsRoleManager;
use Yii;
use yii\web\HttpException;
use app\widgets\notification\Alert;
use app\modules\site\controllers\MainBackendController;
use app\modules\marketplace\models\search\MarketplaceSearch;

class MarketplaceBackendController extends MainBackendController
{
    public $modelClass = 'app\modules\marketplace\models\entity\Marketplace';

    public function behaviors()
    {
        $parentAccess = parent::behaviors();

        BehaviorsRoleManager::extendRoles($parentAccess['access']['rules'], [
            ['allow' => true, 'actions' => ['create-product'], 'roles' => ['Administrator']],
        ]);

        return $parentAccess;
    }

    public function actionIndex()
    {
        $model = new $this->modelClass();
        $searchModel = new MarketplaceSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate() && $model->save()) {
                    Alert::setSuccessNotify('Элемент успешно добавлен.');
                    return $this->refresh();
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
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate() && $model->update()) {
                    Alert::setSuccessNotify('Элемент успешно обновлен.');
                    return $this->refresh();
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');
        if ($model->delete()) Alert::setSuccessNotify("Элемент {$model->name} успешно удален");
        return $this->redirect(['index']);
    }

    // other

    public function actionCreateProduct()
    {
        $model = new MarketplaceCreateProductForm();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $ms = new MarketplaceService();
                if ($ms->createProduct(intval($model->product_id))) {
                    Alert::setSuccessNotify('Товар отправлен на маркетплейс.');
                    return $this->refresh();
                }
            }
        }

        return $this->render('create-product', [
            'model' => $model
        ]);
    }
}
