<?php

namespace app\modules\user\controllers;

use app\modules\bonus\models\helper\BonusHelper;
use app\modules\site\models\tools\Debug;
use app\modules\user\models\entity\Auth;
use app\modules\user\models\entity\UserResetPassword;
use app\modules\user\models\form\PasswordRestoreForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\widgets\ActiveForm;
use app\widgets\notification\Alert;
use app\modules\user\models\entity\User;

class AuthController extends Controller
{
    public function actions()
    {
        return [
            'vk' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['allow' => false, 'actions' => ['signin', 'signup', 'restore', 'restoring', 'vk'], 'roles' => ['@']],
                    ['allow' => true, 'actions' => ['signin', 'signup', 'restore', 'restoring', 'vk'], 'roles' => ['?']],
                ],
            ],
        ];
    }

    public function onAuthSuccess($client)
    {
        exit();
        $attributes = $client->getUserAttributes();

        /* @var $auth Auth */
        $auth = Auth::find()->where([
            'source' => $client->getId(),
            'source_id' => $attributes['id'],
        ])->one();

        if (Yii::$app->user->isGuest) {
            if ($auth) { // авторизация
                $user = $auth->user;
                Yii::$app->user->login($user);
            } else { // регистрация
                if (isset($attributes['email']) && User::find()->where(['email' => $attributes['email']])->exists()) {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', "Пользователь с такой электронной почтой как в {client} уже существует, но с ним не связан. Для начала войдите на сайт использую электронную почту, для того, что бы связать её.", ['client' => $client->getTitle()]),
                    ]);
                } else {

                    Debug::p($attributes);
                    exit();


                    $password = Yii::$app->security->generateRandomString(6);
                    $user = new User([
                        'email' => $attributes['email'],
                        'password' => $password,
                    ]);
                    $user->generateAuthKey();
                    $user->generatePasswordResetToken();


                    $transaction = $user->getDb()->beginTransaction();


                    if ($user->save()) {
                        $auth = new Auth([
                            'user_id' => $user->id,
                            'source' => $client->getId(),
                            'source_id' => (string)$attributes['id'],
                        ]);
                        if ($auth->save()) {
                            $transaction->commit();
                            Yii::$app->user->login($user);
                        } else {
                            print_r($auth->getErrors());
                        }
                    } else {
                        print_r($user->getErrors());
                    }
                }
            }
        } else { // Пользователь уже зарегистрирован
            if (!$auth) { // добавляем внешний сервис аутентификации
                $auth = new Auth([
                    'user_id' => Yii::$app->user->id,
                    'source' => $client->getId(),
                    'source_id' => $attributes['id'],
                ]);
                $auth->save();
            }
        }
    }

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
                return $this->redirect(['/']);
            } else {
                Alert::setErrorNotify('Авторизация не получилась.');
                return $this->redirect(['/']);
            }
        }

        if (Yii::$app->request->isAjax) return $this->redirect(['/']);
        else return $this->render('signin', [
            'model' => $model
        ]);
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
        else return $this->render('signup', [
            'model' => $model
        ]);
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