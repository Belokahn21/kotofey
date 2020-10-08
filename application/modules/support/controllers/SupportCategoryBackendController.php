<?php

namespace app\modules\support\controllers;


use app\models\entity\support\SupportCategory;
use app\widgets\notification\Alert;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class SupportCategoryBackendController extends Controller
{
    public $layout = '@app/views/layouts/admin';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['Administrator', 'Developer'],
                    ],
                    [
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new SupportCategory();

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Alert::setSuccessNotify('Раздел тех. поддержки создан');
                        return $this->refresh();
                    }
                }
            }
        }

        return $this->render('index', [
            'model' => $model
        ]);
    }
}