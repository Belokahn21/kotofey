<?php

namespace app\modules\user\controllers;

use app\modules\bonus\models\helper\BonusHelper;
use Yii;
use yii\web\Controller;
use yii\widgets\ActiveForm;
use app\widgets\notification\Alert;
use app\modules\user\models\entity\User;

class AuthController extends Controller
{
    public function actionSignin()
    {
        $model = new User(['scenario' => User::SCENARIO_LOGIN]);

        if ($model->load(\Yii::$app->request->post())) {
            if (!$model->validate()) {
                Alert::setErrorNotify('Введены некоректные данные.');
                return $this->redirect(['/']);
            }

            $user = User::findByEmail($model->email);
            if (!$user) {

                Alert::setErrorNotify('Пользователя с таким Email не существует.');
                return $this->redirect(['/']);
            }

            if (!$user->validatePassword($model->password)) {
                Alert::setErrorNotify('Пароль не верный.');
                return $this->redirect(['/']);
            }

            if (\Yii::$app->user->login($user, 3600000)) {
                Alert::setSuccessNotify('Вы успешно авторизовались.');
            } else {
                Alert::setErrorNotify('Авторизация не получилась.');
                return $this->redirect(['/']);
            }
        }

        return $this->redirect(['/']);
    }

    public function actionSignup()
    {
        $model = new User(['scenario' => User::SCENARIO_INSERT]);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(\Yii::$app->request->post())) {

            $model->setPassword($model->password);
            $model->generateAuthKey();

            if (!$model->validate()) {
                Alert::setErrorNotify('Данные некоректные.');
                return $this->redirect(['/']);
            }

            if (!$model->save()) {
                Alert::setErrorNotify('Ошибка при создании пользователя.');
                return $this->redirect(['/']);
            }

            BonusHelper::createBonusAccount($model->phone);

            if (!\Yii::$app->user->login($model, 3600000)) {
                Alert::setErrorNotify('Ошибка при авторизации нового пользователя.');
                return $this->redirect(['/']);
            }

            Alert::setSuccessNotify('Вы успешно зарегестрировались и вошли на сайт.');
        }

        return $this->redirect(['/']);
    }
}