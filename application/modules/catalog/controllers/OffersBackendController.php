<?php

namespace app\modules\catalog\controllers;

use app\modules\catalog\models\entity\Product;
use Yii;
use yii\helpers\Url;
use yii\web\HttpException;
use yii\widgets\ActiveForm;
use app\widgets\notification\Alert;
use app\modules\stock\models\entity\Stocks;
use app\modules\catalog\models\entity\Properties;
use app\modules\catalog\models\entity\Composition;
use app\modules\catalog\models\entity\ProductOrder;
use app\modules\catalog\models\entity\ProductMarket;
use app\modules\catalog\models\form\PriceRepairForm;
use app\modules\user\models\tool\BehaviorsRoleManager;
use app\modules\catalog\models\search\OffersSearchForm;
use app\modules\site\controllers\MainBackendController;


class OffersBackendController extends MainBackendController
{
    public $layout = '@app/views/layouts/admin';
    public $modelClass = 'app\modules\catalog\models\entity\Offers';

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
        $products = $this->getProducts();
        $modelDelivery = new ProductOrder();
        $properties = $this->getProperties();
        $compositions = $this->getCompositions();
        $stocks = $this->getStocks();
        $searchModel = new OffersSearchForm();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $outProps = [];
        foreach ($properties as $prop) {
            $outProps[$prop->group_id][] = $prop;
        }

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
            'stocks' => $stocks,
            'compositions' => $compositions,
            'properties' => $outProps,
//            'properties' => $properties,
            'modelDelivery' => $modelDelivery,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'products' => $products,
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Товар такой не существует');

        $model->scenario = $this->modelClass::SCENARIO_UPDATE_PRODUCT;
        $products = $this->getProducts();
        $properties = $this->getProperties();
        $compositions = $this->getCompositions();
        $stocks = $this->getStocks();
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
            'compositions' => $compositions,
            'stocks' => $stocks,
            'modelDelivery' => $modelDelivery,
            'properties' => $outProps,
            'products' => $products,
        ]);
    }

    public function actionCopy($id)
    {
        if (!$oldProduct = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не неайден');
        $oldProduct->scenario = $this->modelClass::SCENARIO_NEW_PRODUCT;
        $properties = $this->getProperties();
        $compositions = $this->getCompositions();
        $stocks = $this->getStocks();
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
            'stocks' => $stocks,
            'compositions' => $compositions,
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
            ->where("`price`=`purchase`")
            ->orWhere('round((price / purchase) * 100 - 100) < :markup', [
                ':markup' => Yii::$app->request->get('markup', 15)
            ]);

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

    private function getCompositions()
    {
        return Yii::$app->cache->getOrSet('product-composition-backend', function () {
            return Composition::find()->where(['is_active' => true])->all();
        });
    }

    private function getStocks()
    {
        return Yii::$app->cache->getOrSet('product-stocks-backend', function () {
            return Stocks::find()->where(['active' => true])->all();
        });
    }

    private function getProperties()
    {
        return Yii::$app->cache->getOrSet('product-properties-backend', function () {
            return Properties::find()->all();
        });
    }

    private function getProducts()
    {
        return Yii::$app->cache->getOrSet('products-to-offers', function () {
            return Product::find()->all();
        });
    }
}
