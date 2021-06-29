<?php

namespace app\modules\promotion\controllers;

use app\modules\catalog\models\helpers\ProductHelper;
use app\modules\logger\models\service\LogService;
use app\modules\mailer\models\services\MailService;
use app\modules\order\models\entity\Order;
use app\modules\order\models\entity\OrdersItems;
use app\modules\order\models\service\NotifyService;
use app\modules\promotion\models\entity\PromotionProductMechanics;
use app\modules\promotion\models\forms\PromotionProductMechanicsForm;
use app\modules\promotion\models\helpers\PromotionProductMechanicHelper;
use app\modules\promotion\models\search\PromotionSearch;
use app\modules\site\models\tools\Currency;
use app\modules\site\models\tools\Debug;
use app\modules\site\models\tools\Price;
use app\widgets\notification\Alert;
use yii\web\Controller;
use yii\web\HttpException;

class PromotionBackendController extends Controller
{
    public $layout = '@app/views/layouts/admin';
    public $modelClass = 'app\modules\promotion\models\entity\Promotion';
    public $modelClassPromoMechanis = 'app\modules\promotion\models\forms\PromotionProductMechanicsForm';

    public function actionIndex()
    {
        $model = new $this->modelClass();
        $searchModel = new PromotionSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());
        $count = count(\Yii::$app->request->post('PromotionProductMechanicsForm', [[], [], [], [], [], []]));
        $PromotionProductMechanicsForm = [new $this->modelClassPromoMechanis()];
        for ($i = 1; $i < $count; $i++) $PromotionProductMechanicsForm[] = new $this->modelClassPromoMechanis();

        if (\Yii::$app->request->isPost) {
            $model->load(\Yii::$app->request->post());

            if (!$model->validate() or !$model->save()) {
                Alert::setErrorNotify('Ошибка №1');
                return $this->refresh();
            }


            if ($this->modelClassPromoMechanis::loadMultiple($PromotionProductMechanicsForm, \Yii::$app->request->post())) {
                foreach ($PromotionProductMechanicsForm as $item) {

                    if (PromotionProductMechanicHelper::isSkip($item)) continue;

                    $item->promotion_id = $model->id;
                    if (!$item->validate() or !$item->save()) {
                        Alert::setErrorNotify('Ошибка №2');
                        return $this->refresh();
                    }
                }
            }

            $notify = new NotifyService();
            $notify->notifyBeginSale($model);

            Alert::setSuccessNotify('Акция успешно сохранена');
            return $this->refresh();
        }

        return $this->render('index', ['model' => $model,
            'subModel' => $PromotionProductMechanicsForm,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');

        if (!$subModel = $this->modelClassPromoMechanis::findAll(['promotion_id' => $model->id])) {
            $subModel = new $this->modelClassPromoMechanis();
        }

        if (\Yii::$app->request->isPost) {
            $model->load(\Yii::$app->request->post());

            if (!$model->validate() or !$model->update()) {
                Alert::setErrorNotify('Ошибка №1');
                return $this->refresh();
            }

            $this->modelClassPromoMechanis::deleteAll(['promotion_id' => $model->id]);
            $count = count(\Yii::$app->request->post('PromotionProductMechanicsForm', []));
            $items = [new $this->modelClassPromoMechanis()];
            for ($i = 1; $i < $count + 3; $i++) $items[] = new $this->modelClassPromoMechanis();

            if ($this->modelClassPromoMechanis::loadMultiple($items, \Yii::$app->request->post())) {
                foreach ($items as $item) {

                    if (PromotionProductMechanicHelper::isSkip($item)) continue;

                    $item->promotion_id = $model->id;
                    if (!$item->validate() or !$item->save()) {
                        Alert::setErrorNotify('Ошибка №2');
                        return $this->refresh();
                    }
                }
            }


            Alert::setSuccessNotify('Акция успешно сохранена');
            return $this->refresh();
        }

        return $this->render('update', [
            'model' => $model,
            'subModel' => $subModel,
        ]);
    }

    public function actionDelete($id)
    {
        if (!$model = $this->modelClass::findOne($id)) throw new HttpException(404, 'Элемент не найден');

        if ($model->delete()) {
            Alert::setSuccessNotify('Элемент успешно удален');
        }

        return $this->redirect(['index']);
    }
}
