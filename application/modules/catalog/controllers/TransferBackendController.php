<?php


namespace app\modules\catalog\controllers;

use Yii;
use app\modules\catalog\models\entity\Product;
use app\modules\catalog\models\form\ProductTransferHistoryForm;
use app\modules\catalog\models\search\ProductTransferHistorySearch;
use app\modules\order\models\entity\Order;
use app\modules\site\controllers\MainBackendController;
use app\widgets\notification\Alert;
use yii\web\HttpException;

class TransferBackendController extends MainBackendController
{
    public function actionIndex()
    {
        $model = new ProductTransferHistoryForm();
        $orders = Order::find()->orderBy(['created_at' => SORT_DESC])->all();
        $products = Product::find()->orderBy(['created_at' => SORT_DESC])->all();
        $searchModel = new ProductTransferHistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

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
            'orders' => $orders,
            'products' => $products,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = ProductTransferHistoryForm::findOne($id)) throw new HttpException(404, 'Элемент не найден.');

        $orders = Order::find()->orderBy(['created_at' => SORT_DESC])->all();
        $products = Product::find()->orderBy(['created_at' => SORT_DESC])->all();

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
            'orders' => $orders,
            'products' => $products,
        ]);
    }

    public function actionDelete($id)
    {
        if (!$model = ProductTransferHistoryForm::findOne($id)) throw new HttpException(404, 'Элемент не найден.');

        if ($model->delete()) Alert::setSuccessNotify('Элемент успешно удален.');

        return $this->refresh();
    }
}