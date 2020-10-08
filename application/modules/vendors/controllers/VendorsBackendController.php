<?php

namespace app\modules\vendors\controllers;

use app\modules\vendors\models\search\VendorSearchForm;
use app\widgets\notification\Alert;
use Yii;
use app\modules\vendors\models\entity\Vendor;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\HttpException;

class VendorsBackendController extends Controller
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
        $model = new Vendor();
        $searchModel = new VendorSearchForm();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    return $this->refresh();
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
        $model = Vendor::findOne($id);
        if (!$model) {
            throw new HttpException(404, 'Поставщик не существует');
        }
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->update()) {
                    return $this->refresh();
                }
            }
        }
        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        if (Vendor::findOne($id)->delete()) {
            Alert::setSuccessNotify('Поставщик удалён');
        }

        return $this->redirect(['index']);
    }
}
