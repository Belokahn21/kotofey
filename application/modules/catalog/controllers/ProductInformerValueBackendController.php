<?php

namespace app\modules\catalog\controllers;


use app\modules\catalog\models\entity\InformersValues;
use app\modules\catalog\models\search\InformersValuesSearchForm;
use app\models\tool\Debug;
use app\widgets\notification\Alert;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\HttpException;

class ProductInformerValueBackendController extends Controller
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
        $model = new InformersValues();
        $searchModel = new InformersValuesSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Alert::setSuccessNotify('Значение справочника добавлено');
                        return $this->refresh();
                    }
                } else {
                    Alert::setErrorNotify(Debug::modelErrors($model));
                }
            }
        }

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = InformersValues::findOne($id);
        if (!$model) {
            throw new HttpException(404, 'Запись не существует');
        }
        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->update()) {
                        Alert::setSuccessNotify('Значение справочника обновлено');
                        return $this->refresh();
                    }
                }
            }
        }


        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        if (InformersValues::findOne($id)->delete()) {
            Alert::setSuccessNotify('Значение справочника удалено');
        }
        return $this->redirect(['index']);
    }
}