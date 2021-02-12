<?php

namespace app\modules\user\controllers;

use app\modules\bonus\models\helper\BonusHelper;
use app\modules\user\models\entity\UserResetPassword;
use app\modules\user\models\form\PasswordRestoreForm;
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

            if (!$user = User::findByEmail($model->email)) {
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

        if (Yii::$app->request->isAjax) return $this->redirect(['/']);
        else return $this->render('signin');
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

        if (Yii::$app->request->isAjax) return $this->redirect(['/']);
        else return $this->render('signup');
    }

    public function actionRestore()
    {
        $model = new PasswordRestoreForm(['scenario' => PasswordRestoreForm::SCENARIO_SEND_MAIL]);

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate() && $model->submit()) {
                    Alert::setSuccessNotify('На ваш электронный адрес ' . $model->email . ' отправлено письмо с инструкциями по восстановлению.');
                    return $this->refresh();
                }
            }
        }

        if (Yii::$app->request->isAjax) return $this->redirect(['/']);
        else return $this->render('restore', [
            'model' => $model,
            'message' => null
        ]);
    }

    public function actionRestoring($id)
    {
        $modelRestoreKey = UserResetPassword::findOneByCode($id);

        if (!$modelRestoreKey) return $this->redirect(['/']);

        if (!$modelRestoreKey->isAlive()) {
            $model = new PasswordRestoreForm(['scenario' => PasswordRestoreForm::SCENARIO_SEND_MAIL]);

            return $this->render('restore', [
                'model' => $model,
                'message' => 'Срок ссылки восстановления пароля закончился'
            ]);
        }

        $model = new PasswordRestoreForm(['scenario' => PasswordRestoreForm::SCENARIO_UPDATE_PASSWORD]);

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->updatePassword($modelRestoreKey->user_id)) {
                    Alert::setSuccessNotify('Пароль успешно сменен.');
                    return $this->redirect(['/']);
                }
            }
        }

        return $this->render('change', [
            'model' => $model
        ]);
    }
}