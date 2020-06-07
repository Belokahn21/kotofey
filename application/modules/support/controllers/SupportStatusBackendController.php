<?php

namespace app\modules\support\controllers;


use app\models\entity\support\SupportStatus;
use yii\web\Controller;

class SupportStatusBackendController extends Controller
{
    public $layout = '@app/views/layouts/admin';

    public function actionIndex()
    {
        $model = new SupportStatus();

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->save()) {
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