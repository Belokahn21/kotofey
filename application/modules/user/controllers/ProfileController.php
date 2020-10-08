<?php

namespace app\modules\user\controllers;


use app\models\tool\Debug;
use app\widgets\notification\Alert;
use Yii;
use yii\web\Controller;
use app\modules\user\models\entity\User;
use app\modules\order\models\entity\Order;
use app\modules\user\models\entity\UserSex;

class ProfileController extends Controller
{
    public function actionIndex()
    {
        $orders = Order::find()->where(['phone' => \Yii::$app->user->identity->phone])->orWhere(['user_id' => \Yii::$app->user->identity->id])->all();
        $model = User::findOne(\Yii::$app->user->id);
        $model->scenario = User::SCENARIO_PROFILE_UPDATE;
        $sexList = UserSex::find()->all();

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

        return $this->render('index', [
            'orders' => $orders,
            'model' => $model,
            'sexList' => $sexList,
        ]);
    }

    public function actionLogout()
    {
        \Yii::$app->user->logout();
        return $this->redirect(['/']);
    }
}