<?php

namespace app\modules\user\controllers;


use app\modules\bonus\models\entity\UserBonus;
use app\modules\bonus\models\entity\UserBonusHistory;
use app\modules\pets\models\entity\Animal;
use app\modules\pets\models\entity\Pets;
use app\modules\site\models\tools\Debug;
use app\modules\user\models\entity\UserBilling;
use app\widgets\notification\Alert;
use Yii;
use yii\web\Controller;
use app\modules\user\models\entity\User;
use app\modules\order\models\entity\Order;
use app\modules\user\models\entity\UserSex;
use yii\web\HttpException;

class ProfileController extends Controller
{
    public function actionIndex()
    {
        $orders = Order::find()->where(['phone' => \Yii::$app->user->identity->phone])->orWhere(['user_id' => \Yii::$app->user->identity->id])->orderBy(['created_at' => SORT_DESC])->all();
        $model = User::findOne(\Yii::$app->user->id);
        $model->scenario = User::SCENARIO_PROFILE_UPDATE;
        $sexList = UserSex::find()->all();
        $history = UserBonusHistory::find()->where(['bonus_account_id' => Yii::$app->user->identity->phone])->orderBy(['created_at' => SORT_DESC]);
        $petModel = new Pets();
        $animals = Animal::find()->all();
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
            'history' => $history,
            'petModel' => $petModel,
            'animals' => $animals,
            'billings' => $billings,
            'billingModel' => $billingModel,
        ]);
    }

    public function actionBilling($id)
    {
        $billing = UserBilling::findOne($id);

        if (!$billing) throw new HttpException(404, 'Элемент не найден.');
        if (!$billing->hasAccess()) throw new \Exception('Доступ запрещён.');

        return $this->render('billing');
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