<?php

namespace app\modules\support\controllers;


use app\models\entity\support\SupportCategory;
use app\widgets\notification\Alert;
use yii\web\Controller;

class SupportCategoryBackendController extends Controller
{
    public $layout = '@app/views/layouts/admin';

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