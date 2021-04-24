<?php

namespace app\modules\user\controllers;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use app\widgets\notification\Alert;
use app\modules\site\models\tools\Debug;
use app\modules\user\models\entity\User;
use app\modules\order\models\entity\Order;
use app\modules\user\models\entity\UserSex;
use app\modules\user\models\entity\UserBilling;
use app\modules\bonus\models\entity\UserBonusHistory;

class ProfileController extends Controller
{
    public function actionIndex()
    {
        $orders = Order::find()->where(['phone' => \Yii::$app->user->identity->phone])->orWhere(['user_id' => \Yii::$app->user->identity->id])->orderBy(['created_at' => SORT_DESC])->all();
        $model = User::findOne(\Yii::$app->user->id);
        $model->scenario = User::SCENARIO_PROFILE_UPDATE;
        $sexList = UserSex::find()->all();

        $billingModel = new UserBilling();
        $billings = UserBilling::find()->where(['phone' => Yii::$app->user->identity->phone])->all();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->update()) {
                    Alert::setSuccessNotify('Профиль успешно обновлён.');
                    return $this->refresh();
                }
            } else {
                Debug::p($model->getErrors());
            }
        }

        if ($billingModel->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isPost) {
                if ($billingModel->load(Yii::$app->request->post())) {
                    $billingModel->phone = Yii::$app->user->identity->phone;
                    if ($billingModel->validate() && $billingModel->save()) {
                        Alert::setSuccessNotify('Адрес доставки успешно добавлен.');
                        return $this->refresh();
                    }
                }
            }
        }

        return $this->render('index', [
            'orders' => $orders,
            'model' => $model,
            'sexList' => $sexList,
            'billings' => $billings,
            'billingModel' => $billingModel,
        ]);
    }

    public function actionBilling($id)
    {
        $model = UserBilling::findOne($id);

        if (!$model) throw new HttpException(404, 'Элемент не найден.');
        if (!$model->hasAccess()) throw new \Exception('Доступ запрещён.');

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate() && $model->update()) {
                    Alert::setSuccessNotify('Элемент успешно обновлён.');
                    return $this->refresh();
                }
            }
        }

        return $this->render('billing', [
            'model' => $model
        ]);
    }

    public function actionBillingDelete($id)
    {
        $billing = UserBilling::findOne($id);

        if (!$billing) throw new HttpException(404, 'Элемент не найден.');
        if (!$billing->hasAccess()) throw new \Exception('Доступ запрещён.');
        if ($billing->is_main) throw new \Exception('Нельзя удалить основной вариант доставки.');


        if ($billing->delete()) Alert::setSuccessNotify('Доставка успешно удалена.');

        return $this->redirect(['index']);
    }

    public function actionLogout()
    {
        \Yii::$app->user->logout();
        return $this->redirect(['/']);
    }
}