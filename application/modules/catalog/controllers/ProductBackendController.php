<?php

namespace app\modules\catalog\controllers;

use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\Properties;
use app\modules\catalog\models\form\PriceRepairForm;
use app\modules\user\models\tool\BehaviorsRoleManager;
use Yii;
use app\modules\catalog\models\search\ProductSearchForm;
use app\modules\site\controllers\MainBackendController;
use app\modules\catalog\models\entity\ProductMarket;
use app\modules\catalog\models\entity\ProductOrder;
use app\widgets\notification\Alert;
use yii\widgets\ActiveForm;
use yii\web\HttpException;
use yii\helpers\Url;


class ProductBackendController extends MainBackendController
{
    public $layout = '@app/views/layouts/admin';
    public $modelClass = 'app\modules\catalog\models\entity\Product';

    public function behaviors()
    {
        $parentAccess = parent::behaviors();

        BehaviorsRoleManager::extendRoles($parentAccess['access']['rules'], [
            ['allow' => true, 'actions' => ['copy'], 'roles' => ['Administrator', 'Content']],
            ['allow' => true, 'actions' => ['transfer', 'price-repair'], 'roles' => ['Administrator']],
            ['allow' => true, 'actions' => ['index', 'update'], 'roles' => ['Content']]
        ]);

        return $parentAccess;
    }

    public function actionIndex()
    {
        $model = new $this->modelClass(['scenario' => $this->modelClass::SCENARIO_NEW_PRODUCT]);
        $modelDelivery = new ProductOrder();
        $properties = Properties::find()->all();

        $outProps = [];
        foreach ($properties as $prop) {
            $outProps[$prop->group_id][] = $prop;
        }

        $searchModel = new ProductSearchForm();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->createProduct()) {
            Alert::setSuccessNotify('Продукт создан');
            return $this->refresh();
        }

        return $this->render('index', [
            'model' => $model,
            'properties' => $outProps,
//            'properties' => $properties,
            'modelDelivery' => $modelDelivery,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Товар такой не существует');

        $model->scenario = $this->modelClass::SCENARIO_UPDATE_PRODUCT;
        $properties = Properties::find()->all();
        if (ProductMarket::hasStored($model->id)) $model->has_store = true;
        if (!$modelDelivery = ProductOrder::findOneByProductId($model->id)) $modelDelivery = new ProductOrder();

        $outProps = [];
        foreach ($properties as $prop) {
            $outProps[$prop->group_id][] = $prop;
        }

        if ($model->updateProduct()) {
            Alert::setSuccessNotify('Продукт обновлен');
            return $this->refresh();
        }

        return $this->render('update', [
            'model' => $model,
            'modelDelivery' => $modelDelivery,
            'properties' => $outProps,
        ]);
    }

    public function actionCopy($id)
    {
        if (!$oldProduct = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не неайден');
        $oldProduct->scenario = $this->modelClass::SCENARIO_NEW_PRODUCT;
        $properties = Properties::find()->all();
        $outProps = [];
        foreach ($properties as $prop) {
            $outProps[$prop->group_id][] = $prop;
        }
        if (!$modelDelivery = ProductOrder::findOneByProductId($oldProduct->id)) $modelDelivery = new ProductOrder();

        $model = clone $oldProduct;
        $model->scenario = $this->modelClass::SCENARIO_NEW_PRODUCT;
        $model->id = null;
        $model->article = null;
        $model->isNewRecord = true;

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->createProduct()) {
                    Alert::setSuccessNotify('Элемент успешно склонирован');
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('copy', [
            'model' => $oldProduct,
            'modelDelivery' => $modelDelivery,
            'properties' => $outProps,
        ]);
    }

    public function actionPriceRepair()
    {
        $model = new PriceRepairForm();

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate() && $model->run()) {
                    Alert::setSuccessNotify('Товарам успешно сменили цену');
                    return $this->refresh();
                }
            }
        }

        $models = $this->modelClass::find()
            ->where("`price`=`purchase`");

        $models = $models->all();


        return $this->render('price-repair', [
            'models' => $models,
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $product = $this->modelClass::findOne($id);

        if (!$product) throw new HttpException(404, 'Товара не существует');

        if ($product->delete()) Alert::setSuccessNotify('Продукт удалён');

        return $this->redirect(Url::to(['index']));
    }
}
