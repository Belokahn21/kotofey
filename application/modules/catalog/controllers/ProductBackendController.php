<?php

namespace app\modules\catalog\controllers;

use app\modules\catalog\models\entity\ProductMarket;
use app\modules\catalog\models\entity\SaveProductProperties;
use app\modules\catalog\models\search\ProductSearchForm;
use app\modules\site\controllers\MainBackendController;
use Yii;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\entity\ProductOrder;
use app\widgets\notification\Alert;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\HttpException;
use yii\widgets\ActiveForm;


class ProductBackendController extends MainBackendController
{
    public $layout = '@app/views/layouts/admin';


    public function behaviors()
    {
        $parentAccess = parent::behaviors();
        $oldRules = $parentAccess['access']['rules'];
        $newRules = [['allow' => true, 'actions' => ['discount-clean'], 'roles' => ['Administrator']]];


        $parentAccess['access']['rules'] = array_merge($newRules, $oldRules);

        return $parentAccess;
    }

    public function actionIndex()
    {
        $model = new Product(['scenario' => Product::SCENARIO_NEW_PRODUCT]);
        $modelDelivery = new ProductOrder();
        $properties = SaveProductProperties::find()->all();
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
            'properties' => $properties,
            'modelDelivery' => $modelDelivery,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Product::findOne($id);

        if (!$model) throw new HttpException(404, 'Товар такой не существует');

        $model->scenario = Product::SCENARIO_UPDATE_PRODUCT;
        if (ProductMarket::hasStored($model->id)) {
            $model->has_store = true;
        }
        $properties = SaveProductProperties::find()->all();
        if (!$modelDelivery = ProductOrder::findOneByProductId($model->id)) {
            $modelDelivery = new ProductOrder();
        }

        if (Yii::$app->request->get('action') == 'copy') {
            if (Yii::$app->request->post('action') == 'Копировать') {
                $model->id = null;
                $model->article = null;
                $model->isNewRecord = true;
                $model->scenario = Product::SCENARIO_NEW_PRODUCT;
                if ($model->createProduct()) {
                    Alert::setSuccessNotify('Продукт скопирован');
                    return $this->redirect('/admin/catalog/');
                }
            }

        }

        if ($model->updateProduct()) {
            Alert::setSuccessNotify('Продукт обновлен');
            return $this->refresh();
        }

        return $this->render('update', [
            'model' => $model,
            'modelDelivery' => $modelDelivery,
            'properties' => $properties,
        ]);
    }

    public function actionCopy()
    {

    }

    public function actionDiscountClean()
    {
        $products = Product::find()->where(['>', 'discount_price', 0]);
        $hasItems = $products->count() > 0;

        foreach ($products->all() as $product) {
            $product->discount_price = null;

            $product->scenario = Product::SCENARIO_UPDATE_PRODUCT;

            if (!$product->validate() or !$product->update()) {
                $hasItems = false;
                break;
            }
        }

        if ($hasItems) Alert::setSuccessNotify('Товары со скидкой очищены успешно');

        return $this->redirect(['index']);
    }

    public function actionDelete($id)
    {
        $product = Product::findOne($id);

        if (!$product) {
            throw new HttpException(404, 'Товара не существует');
        }

        if ($product->delete()) {
            Alert::setSuccessNotify('Продукт удалён');
        }

        return $this->redirect(Url::to(['index']));
    }
}
