<?php

namespace app\modules\catalog\controllers;

use app\modules\site\models\tools\Debug;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\widgets\ActiveForm;
use app\models\tool\parser\ParseProvider;
use app\modules\catalog\models\entity\NotifyAdmission;

class AjaxController extends Controller
{
    public function actionCatalogFillFromVendor()
    {
        $data = \Yii::$app->request->post();

        $factory = new ParseProvider($data['link']);
        $factory->contract();

        return Json::encode($factory->getInfo());
    }

    public function actionSaveNotifyAdmission()
    {
        $model = new NotifyAdmission();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if (!$model->validate()) return ActiveForm::validate($model);
            if ($model->save()) return [
                'success' => 'Вы успешно подписались на товар'
            ];
        }
    }
}