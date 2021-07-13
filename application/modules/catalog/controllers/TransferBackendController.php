<?php


namespace app\modules\catalog\controllers;

use app\modules\site\models\tools\Debug;
use Yii;
use app\modules\catalog\models\entity\Offers;
use app\modules\catalog\models\search\ProductTransferHistorySearch;
use app\modules\order\models\entity\Order;
use app\modules\site\controllers\MainBackendController;
use app\widgets\notification\Alert;
use yii\web\HttpException;

class TransferBackendController extends MainBackendController
{
    public $modelClass = 'app\modules\catalog\models\entity\ProductTransferHistory';

    public function actionIndex()
    {
        $model = new $this->modelClass();
        $orders = Order::find()->orderBy(['created_at' => SORT_DESC])->all();
        $products = Offers::find()->orderBy(['created_at' => SORT_DESC])->all();
        $searchModel = new ProductTransferHistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate() && $model->save()) {
                    Alert::setSuccessNotify('Элемент успешно добавлен.');
                    return $this->refresh();
                } else {
                    Debug::p($model->getErrors());
                    exit();
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
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден.');

        $orders = Order::find()->orderBy(['created_at' => SORT_DESC])->all();
        $products = Offers::find()->orderBy(['created_at' => SORT_DESC])->all();

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
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден.');

        if ($model->delete()) Alert::setSuccessNotify('Элемент успешно удален.');

        return $this->refresh();
    }
}