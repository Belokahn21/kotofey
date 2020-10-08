<?php

namespace app\modules\short_link\controllers;

use Yii;
use app\modules\short_link\models\entity\ShortLinks;
use app\modules\short_link\models\search\ShortLinksSearchModel;
use app\widgets\notification\Alert;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\HttpException;

class ShortLinkBackendController extends Controller
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
        $model = new ShortLinks();
        $searchModel = new ShortLinksSearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->get());


        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
                        Alert::setSuccessNotify('Короткая ссылка успешно добавлена');
                        return $this->refresh();
                    }
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
        $model = ShortLinks::findOne($id);

        if (!$model) {
            throw new HttpException(404, 'Запись не найдена');
        }

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->update()) {
                        Alert::setSuccessNotify('Короткая ссылка успешно обновлена');
                        return $this->refresh();
                    }
                }
            }
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        if (ShortLinks::findOne($id)->delete()) {
            Alert::setSuccessNotify('Короткая ссылка удалена');
        }
        return $this->redirect(['index']);
    }
}
