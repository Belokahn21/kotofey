<?php

namespace app\modules\catalog\controllers;


use app\modules\catalog\models\form\SibagroUpload;
use yii\web\Controller;

class UpdateSibagroController extends Controller
{
    public $layout = '@app/views/layouts/admin';

    public function actionUpload()
    {
        $model = new SibagroUpload();

        if (\Yii::$app->request->isPost) {
            if ($model->load(\Yii::$app->request->post())) {
                if($model->parse()){

                }
            }
        }

        return $this->render('upload', [
            'model' => $model
        ]);
    }
}