<?php

namespace app\modules\catalog\controllers;

use app\models\entity\ProductMarket;
use app\models\entity\ProductProperties;
use app\modules\catalog\models\search\ProductSearchForm;
use Yii;
use app\models\entity\Product;
use app\models\entity\ProductOrder;
use app\widgets\notification\Alert;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\HttpException;
use yii\widgets\ActiveForm;


class ProductBackendController extends Controller
{
    public $layout = '@app/views/layouts/admin';

    public function actionIndex()
    {
        $model = new Product(['scenario' => Product::SCENARIO_NEW_PRODUCT]);
        $modelDelivery = new ProductOrder();
        $properties = ProductProperties::find()->all();
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

        if (!$model)  throw new HttpException(404, 'Товар такой не существует');

        $model->scenario = Product::SCENARIO_UPDATE_PRODUCT;
        if (ProductMarket::hasStored($model->id)) {
            $model->has_store = true;
        }
        $properties = ProductProperties::find()->all();
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

    public function actionDelete($id)
    {
        if (Product::findOne($id)->delete()) {
            Alert::setSuccessNotify('Продукт удалён');
        }

        return $this->redirect(Url::to(['index']));
    }
}
