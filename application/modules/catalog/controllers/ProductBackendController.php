<?php

namespace app\modules\catalog\controllers;

use app\modules\catalog\models\entity\Composition;
use app\modules\catalog\models\entity\CompositionType;
use app\modules\catalog\models\entity\Price;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\Properties;
use app\modules\catalog\models\entity\PropertyGroup;
use app\modules\catalog\models\form\PriceRepairForm;
use app\modules\catalog\models\helpers\PropertiesHelper;
use app\modules\catalog\models\repository\CompositionProductsRepository;
use app\modules\pets\models\entity\Animal;
use app\modules\pets\models\entity\Breed;
use app\modules\site\models\tools\Debug;
use app\modules\stock\models\entity\Stocks;
use app\modules\user\models\tool\BehaviorsRoleManager;
use app\modules\vendors\models\entity\Vendor;
use Yii;
use app\modules\catalog\models\search\ProductSearchForm;
use app\modules\site\controllers\MainBackendController;
use app\modules\catalog\models\entity\ProductMarket;
use app\modules\catalog\models\entity\ProductOrder;
use app\widgets\notification\Alert;
use yii\helpers\ArrayHelper;
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
            ['allow' => true, 'actions' => ['index', 'update', 'delete'], 'roles' => ['Content']]
        ]);

        return $parentAccess;
    }

    public function actionIndex()
    {
        $model = new $this->modelClass(['scenario' => $this->modelClass::SCENARIO_NEW_PRODUCT]);
        $modelDelivery = new ProductOrder();
        $properties = $this->getProperties();
        $compositions = $this->getCompositions();
        $stocks = $this->getStocks();
        $prices = $this->getPrices();
        $vendors = $this->getVendors();
        $animals = $this->getAnimals();
        $breeds = $this->getBreeds();
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
            'stocks' => $stocks,
            'prices' => $prices,
            'vendors' => $vendors,
            'animals' => $animals,
            'breeds' => $breeds,
            'compositions' => $compositions,
            'properties' => $properties,
            'modelDelivery' => $modelDelivery,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Товар такой не существует');

        $model->scenario = $this->modelClass::SCENARIO_UPDATE_PRODUCT;
        $properties = $this->getProperties();
        $compositions = $this->getCompositions();
        $stocks = $this->getStocks();
        $prices = $this->getPrices();
        $vendors = $this->getVendors();
        $animals = $this->getAnimals();
        $breeds = $this->getBreeds();
        if (ProductMarket::hasStored($model->id)) $model->has_store = true;
        if (!$modelDelivery = ProductOrder::findOneByProductId($model->id)) $modelDelivery = new ProductOrder();


        return $this->render('update', [
            'model' => $model,
            'compositions' => $compositions,
            'stocks' => $stocks,
            'prices' => $prices,
            'vendors' => $vendors,
            'animals' => $animals,
            'breeds' => $breeds,
            'modelDelivery' => $modelDelivery,
            'properties' => $properties,
        ]);
    }

    public function actionCopy($id)
    {
        if (!$oldProduct = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не неайден');
        $oldProduct->scenario = $this->modelClass::SCENARIO_NEW_PRODUCT;
        $properties = $this->getProperties();
        $compositions = $this->getCompositions();
        $stocks = $this->getStocks();
        $prices = $this->getPrices();
        $animals = $this->getAnimals();
        $vendors = $this->getVendors();
        $breeds = $this->getBreeds();
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
            'prices' => $prices,
            'animals' => $animals,
            'breeds' => $breeds,
            'vendors' => $vendors,
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

        $models = $this->modelClass::find();
        $models = $models->all();

        $_bad_models = [];
        foreach ($models as $model) {
            $brand = PropertiesHelper::extractPropertyById($model, 1);

            if (!$brand) {
                $_bad_models[] = $model;
            }
        }

        $models = $_bad_models;


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
        $compositions = Yii::$app->cache->getOrSet('product-composition-backend', function () {
            return Composition::find()->where(['is_active' => true])->all();
        });

        $grouped_composition = [];
        $list_group_id = [];
        foreach ($compositions as $composition) {
            $list_group_id[] = $composition->id;
        }


        $groups = CompositionProductsRepository::getTypesByIds($list_group_id);
        foreach ($compositions as $composition) {
            $grouped_composition[$composition->composition_type_id]['compositions'][] = $composition;


            foreach ($groups as $group) {
                if ($group->id == $composition->composition_type_id) $grouped_composition[$composition->composition_type_id]['group'] = $group;
            }
        }

        return $grouped_composition;
    }

    private function getStocks()
    {
        return Yii::$app->cache->getOrSet('product-stocks-backend', function () {
            return Stocks::find()->where(['active' => true])->all();
        });
    }

    private function getProperties()
    {
        $outProps = [];
        $group_ids = [];
        $properties = Yii::$app->cache->getOrSet('product-properties-backend', function () {
            return Properties::find()->all();
        });

        foreach ($properties as $prop) {
            $group_ids[] = $prop->group_id;
        }

        $groups = Yii::$app->cache->getOrSet(__CLASS__ . __METHOD__ . implode(',', $group_ids), function () use ($group_ids) {
            return PropertyGroup::find()->where(['id' => $group_ids])->all();
        });

        foreach ($properties as $prop) {
            $outProps[$prop->group_id]['properties'][] = $prop;

            foreach ($groups as $_group) {
                if ($_group->id == $prop->group_id) $outProps[$prop->group_id]['group'] = $_group;
            }
        }


        return $outProps;
    }

    private function getPrices()
    {
        return Yii::$app->cache->getOrSet('product-prices-backend', function () {
            return Price::find()->all();
        });
    }

    private function getVendors()
    {
        return Yii::$app->cache->getOrSet('product-vendors-backend', function () {
            return Vendor::find()->all();
        });
    }

    private function getAnimals()
    {
        return Yii::$app->cache->getOrSet('product-animals-backend', function () {
            return Animal::find()->all();
        });
    }

    private function getBreeds()
    {
        return Yii::$app->cache->getOrSet('product-breeds-backend', function () {
            return Breed::find()->all();
        });
    }
}
